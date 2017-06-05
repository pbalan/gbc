<?php
namespace NalabTnahsarp\VoryxRestTranslationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class VoryxRestTranslationExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (!isset($config['locales'])) {
            throw new \InvalidArgumentException('The "locales" argument must be set.');
        }
        if (!isset($config['namespaces'])) {
            throw new \InvalidArgumentException('The "namespaces" argument must be set.');
        }

        $container->setParameter(
            'voryx_rest_translation.locales',
            $config['locales']
        );
        $container->setParameter(
            'voryx_rest_translation.namespaces',
            $config['namespaces']
        );
    }
}
