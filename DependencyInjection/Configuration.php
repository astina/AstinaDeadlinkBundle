<?php

namespace Astina\Bundle\DeadlinkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('astina_deadlink');

        $rootNode
            ->children()
                ->scalarNode('caching')->defaultFalse()->info('If set to true, URL checks are cached to prevent accessing the same URL multiple times in short order.')->end()
                ->scalarNode('base_url')->defaultNull()->info('Base URL for relative HTML links')->end()
                ->arrayNode('exclude')->prototype('scalar')->end()->defaultValue(array())->info('List of regex patterns to match URls that should not be checked')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
