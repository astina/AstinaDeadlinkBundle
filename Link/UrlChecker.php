<?php

namespace Astina\Bundle\DeadlinkBundle\Link;

class UrlChecker implements UrlCheckerInterface
{
    private $timeout;

    function __construct($timeout = 5)
    {
        $this->timeout = $timeout;
    }

    public function check($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $success = false !== @curl_exec($ch);
        curl_close($ch);

        return $success;
    }
}