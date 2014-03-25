<?php

namespace Astina\Bundle\DeadlinkBundle\Link;

interface UrlExtractorInterface
{
    /**
     * @param $str
     * @return array URLs found in $str
     */
    public function extract($str);

    /**
     * @param boolean $decodeHtml
     */
    public function setDecodeHtml($decodeHtml);

    /**
     * @param $baseUrl
     */
    public function setBaseUrl($baseUrl);
}