<?php

namespace Astina\Bundle\DeadlinkBundle\Link;

use Symfony\Component\EventDispatcher\Event;

class BrokenLinksEvent extends Event
{
    /**
     * @var LinkSourceInterface
     */
    private $linkSource;

    /**
     * @var Link[]
     */
    private $links;

    const NAME = 'astina_deadlink.broken_links';

    function __construct(LinkSourceInterface $linkSource, array $links)
    {
        $this->linkSource = $linkSource;
        $this->links = $links;
    }

    /**
     * @return \Astina\Bundle\DeadlinkBundle\Link\LinkSourceInterface
     */
    public function getLinkSource()
    {
        return $this->linkSource;
    }

    /**
     * @return \Astina\Bundle\DeadlinkBundle\Link\Link[]
     */
    public function getLinks()
    {
        return $this->links;
    }
}