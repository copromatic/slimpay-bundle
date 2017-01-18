<?php

namespace SlimpayBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SlimpayExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();

        $options = $this->processConfiguration($configuration, $configs);
        if (!(isset($options['apiUrl']) && isset($options['entryPointUrl']) && isset($options['profile'])
            && isset($options['tokenEndPointUrl']) && isset($options['oauthUserId']) && isset($options['oauthPassword']) && isset($options['relNamespace']))) {
            throw new LogicException('You must set apiUrl, entryPointUrl, profilen tokenEndPointUrl, oauthUserId, oauthPassword and relNamespace in your configuration to use SlimpayBundle');
        }
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}
