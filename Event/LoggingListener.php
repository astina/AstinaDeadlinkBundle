<?php

namespace Astina\Bundle\DeadlinkBundle\Event;

use Astina\Bundle\DeadlinkBundle\Link\Link;
use Psr\Log\LoggerInterface;

class LoggingListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    private $level;

    function __construct(LoggerInterface $logger, $level = 'critical')
    {
        $this->logger = $logger;
        $this->level = $level;
    }

    public function onBrokenLinks(BrokenLinksEvent $event)
    {
        $this->logger->log($this->level, 'Broken links found', array(
            'source' => get_class($event->getLinkSource()),
            'links' => $this->createLinksStr($event->getLinks()),
        ));
    }

    /**
     * @param Link[] $links
     * @return string
     */
    private function createLinksStr($links)
    {
        $strings = array();

        foreach ($links as $link) {
            $strings[] = (string) $link;
        }

        return implode(', ', $strings);
    }
}