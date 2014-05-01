<?php

namespace Astina\Bundle\DeadlinkBundle\Tests\Link;

use Astina\Bundle\DeadlinkBundle\Link\ArrayLinkSource;
use Astina\Bundle\DeadlinkBundle\Link\DeadlinkFinder;
use Astina\Bundle\DeadlinkBundle\Link\Link;

class DeadlinkFinderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider urlDataProvider
     */
    public function testRun($url, $urlNotBroken)
    {
        $urlChecker = $this->getMockBuilder('Astina\Bundle\DeadlinkBundle\Link\UrlChecker')
            ->getMock();
        $urlChecker
            ->expects($this->once())
            ->method('check')
            ->with($url)
            ->will($this->returnValue($urlNotBroken))
        ;

        $dispatcher = $this->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcherInterface')
            ->getMock();
        $dispatcher
            ->expects($urlNotBroken ? $this->never() : $this->once())
            ->method('dispatch')
        ;

        $linkSource = new ArrayLinkSource(array(
            new Link($url, 'test'),
        ));

        $deadlinkFinder = new DeadlinkFinder($urlChecker, $dispatcher);
        $deadlinkFinder->addLinkSource($linkSource);
        $deadlinkFinder->run();
    }

    public function urlDataProvider()
    {
        return array(
            array('http://example.org', true),
            array('http://example.org', false),
        );
    }
} 