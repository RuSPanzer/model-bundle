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
        require_once $this->container->getParameter('model.path').'/runtime/lib/Propel.php';

        if (0 === strncasecmp(PHP_SAPI, 'cli', 3)) {
            set_include_path($this->container->getParameter('kernel.root_dir') . '/..' . PATH_SEPARATOR.
                $this->container->getParameter('propel.phing_path') . '/classes'.PATH_SEPARATOR.
                get_include_path());
        }

        if (!\Model::isInit()) {
            \Model::setConfiguration($this->container->get('model.configuration'));
            \Model::initialize();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        /*
        if ($container->hasExtension('security')) {
            $container->getExtension('security')->addUserProviderFactory(new PropelFactory('propel', 'propel.security.user.provider'));
        }*/
    }
}
