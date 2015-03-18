<?php

namespace Model\ModelBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

class ModelExtension extends Extension
{
    /**
     * Loads the Propel configuration.
     *
     * @param array            $configs   An array of configuration settings
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = $this->getConfiguration($configs, $container);
        $config = $processor->processConfiguration($configuration, $configs);

        // Load services
        if (!$container->hasDefinition('model')) {
            $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
            $loader->load('model.xml');
        }

        if (!empty($config['dbal'])) {
            $this->dbalLoad($config['dbal'], $container);
        }

        if (!empty($config['generator'])) {
            $container->setParameter('model.configuration.generator', $config['generator']);
        }
    }

    /**
     * Loads the DBAL configuration.
     *
     * @param array            $config    An array of configuration settings
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    protected function dbalLoad(array $config, ContainerBuilder $container)
    {
        $container->getDefinition('model.configuration')->setArguments(array($config));
    }

    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration($container->getParameter('kernel.debug'));
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return 'model';
    }
}
