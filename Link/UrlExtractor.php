<?php

namespace Astina\Bundle\DeadlinkBundle\Link;

/**
 * Extracts URLs from a string
 */
class UrlExtractor
{
    /**
     * @param $str
     * @return array URLs found in $str
     */
    public function extract($str)
    {
        $pattern = '/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';

        preg_match_all($pattern, $str, $matches, PREG_PATTERN_ORDER);

        $urls = $matches[0];

        return $urls;
    }
}