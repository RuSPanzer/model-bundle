<?php

namespace Model\ModelBundle;

use Model\Model;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ModelBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if (!Model::isInit()) {
            Model::setConfig($this->container->get('model.configuration'));
            Model::initialize();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
