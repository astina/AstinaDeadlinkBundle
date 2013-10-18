<?php

namespace Astina\Bundle\DeadlinkBundle\Link;

class Link
{
    private $url;

    private $context;

    function __construct($url, $context)
    {
        $this->url = $url;
        $this->context = $context;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getContext()
    {
        return $this->context;
    }
}