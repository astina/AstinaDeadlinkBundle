<?php

namespace Astina\Bundle\DeadlinkBundle\Link;

class UrlChecker
{
    private $timeout;

    function __construct($timeout = 5)
    {
        $this->timeout = $timeout;
    }

    /**
     * @param $url
     * @return bool Whether URL is "broken" or not
     */
    public function check($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        $context = stream_context_create(array(
            'http' => array(
                'timeout' => $this->timeout,
            ),
        ));

        $fp = @fopen($url, 'r', false, $context);

        if ($fp) {
            fclose($fp);
        }

        return $fp !== false;
    }
}