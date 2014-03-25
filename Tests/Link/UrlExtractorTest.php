<?php

namespace Astina\Bundle\DeadlinkBundle\Tests\Link;

use Astina\Bundle\DeadlinkBundle\Link\UrlExtractor;

class UrlExtractorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider textProvider
     */
    public function testExtract($text, $expectedUrls, $decodeHtml = false, $baseUrl = null)
    {
        $urlExtractor = new UrlExtractor($decodeHtml, $baseUrl);
        $urls = $urlExtractor->extract($text);

        $this->assertEquals($expectedUrls, $urls);
    }

    public function textProvider()
    {
        return array(
            array('This text contains only one url: https://www.google.com/?q=foo', array('https://www.google.com/?q=foo')),
            array('http://astina.ch there is an url at the beginning', array('http://astina.ch')),
            array('And an url in http://example.org between.', array('http://example.org')),
            array('And some
            line
            https://foo.com <a href="http://www.astina.ch/de/jobs.html?foo=bar#test">html link</a>
            breaks', array('https://foo.com', 'http://www.astina.ch/de/jobs.html?foo=bar#test')),
            array('<a href="http://example.org/?a=b&amp;c=d">text</a>', array('http://example.org/?a=b&c=d'), true),
            array('<a href="/?a=b&amp;c=d">text</a>', array('http://example.org/?a=b&c=d'), true, 'http://example.org'),
            array('<a href="../test.html">text</a>', array(), true, 'http://example.org'),
            array('No urls here', array()),
        );
    }
}