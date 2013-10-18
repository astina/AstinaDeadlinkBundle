<?php

namespace Astina\Bundle\DeadlinkBundle\Tests\Link;

use Astina\Bundle\DeadlinkBundle\Link\UrlChecker;

class UrlCheckerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testCheck($url, $expectedResult)
    {
        $urlChecker = new UrlChecker();
        $result = $urlChecker->check($url);

        $this->assertEquals($expectedResult, $result);
    }

    public function urlProvider()
    {
        return array(
            array('https://www.google.com', true),
            array('http://broken', false),
            array('foo', false),
            array(null, false),
        );
    }
}