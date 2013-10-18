<?php

namespace Astina\Bundle\DeadlinkBundle\Link;

interface LinkSourceInterface
{
    /**
     * @return Link[]
     */
    public function getLinks();
}