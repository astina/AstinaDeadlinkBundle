<?php

namespace Astina\Bundle\DeadlinkBundle\Link;

class ArrayLinkSource implements LinkSourceInterface
{
    /**
     * @var Link[]
     */
    private $links;

    function __construct(array $links)
    {
        $this->links = $links;
    }

    public function getLinks()
    {
        return $this->links;
    }

    public function addLink(Link $link)
    {
        $this->links[] = $link;
    }

    public function setLinks(array $links)
    {
        $this->links = $links;
    }
}