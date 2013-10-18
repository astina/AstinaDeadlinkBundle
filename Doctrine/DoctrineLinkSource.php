<?php

namespace Astina\Bundle\DeadlinkBundle\Doctrine;

use Astina\Bundle\DeadlinkBundle\Link\Link;
use Astina\Bundle\DeadlinkBundle\Link\LinkSourceInterface;
use Astina\Bundle\DeadlinkBundle\Link\UrlExtractor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class DoctrineLinkSource implements LinkSourceInterface
{
    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * @var \Astina\Bundle\DeadlinkBundle\Link\UrlExtractor
     */
    protected $urlExtractor;

    /**
     * @var string
     */
    protected $className;

    /**
     * @var array
     */
    protected $criteria;

    /**
     * @var array
     */
    protected $properties;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;

    function __construct(RegistryInterface $doctrine, $className, array $properties, $criteria = array(), UrlExtractor $urlExtractor)
    {
        $this->manager = $doctrine->getManager();
        $this->className = $className;
        $this->properties = $properties;
        $this->criteria = $criteria;
        $this->propertyAccessor = new PropertyAccessor();
        $this->urlExtractor = $urlExtractor ?: new UrlExtractor();
    }

    public function getLinks()
    {
        $collection = $this->manager->getRepository($this->className)->findBy($this->criteria);

        $classMetaData = $this->manager->getClassMetadata($this->className);

        $links = array();
        foreach ($collection as $entity) {
            foreach ($this->properties as $property) {

                $text = $this->propertyAccessor->getValue($entity, $property);
                if (null == $text) {
                    continue;
                }

                $id = implode('#', $classMetaData->getIdentifierValues($entity));

                $urls = $this->urlExtractor->extract($text);

                foreach ($urls as $url) {
                    $links[] = new Link($url, array('entity_class' => $this->className, 'id' => $id));
                }
            }
        }

        return $links;
    }
}