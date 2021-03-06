<?php

namespace Astina\Bundle\DeadlinkBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AstinaDeadlinkExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('core.xml');

        if ($config['caching']) {
            $loader->load('cache.xml');
            $container->setAlias('astina_deadlink.url_checker', 'astina_deadlink.url_checker.cache');
        }

        if ($config['base_url']) {
            $extractor = $container->getDefinition('astina_deadlink.url_extractor');
            $extractor->addMethodCall('setBaseUrl', array($config['base_url']));
        }

        if ($config['exclude']) {
            $finder = $container->getDefinition('astina_deadlink.deadlink_finder');
            $finder->addMethodCall('setExcludePatterns', array($config['exclude']));
        }
    }
}
