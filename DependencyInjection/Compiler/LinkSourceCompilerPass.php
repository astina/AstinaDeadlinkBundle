<?php

namespace Astina\Bundle\DeadlinkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class LinkSourceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('astina_deadlink.deadlink_finder')) {
            return;
        }

        $definition = $container->getDefinition('astina_deadlink.deadlink_finder');
        foreach ($container->findTaggedServiceIds('astina_deadlink.link_source') as $id => $def) {
            $definition->addMethodCall('addLinkSource', array(new Reference($id)));
        }
    }
}