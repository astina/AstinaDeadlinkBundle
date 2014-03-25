<?php

namespace Astina\Bundle\DeadlinkBundle\Link;

interface UrlCheckerInterface
{
    /**
     * @param $url
     * @return bool Whether URL is "broken" or not
     */
    public function check($url);
} 