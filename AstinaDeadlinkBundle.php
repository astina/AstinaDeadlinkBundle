<?php

namespace Astina\Bundle\DeadlinkBundle;

use Astina\Bundle\DeadlinkBundle\DependencyInjection\Compiler\LinkSourceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AstinaDeadlinkBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new LinkSourceCompilerPass());
    }
}
