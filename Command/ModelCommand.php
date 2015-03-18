<?php
/**
 * Created by PhpStorm.
 * User: RuSPanzer
 * Date: 01.03.2015
 * Time: 12:32
 */

namespace Model\ModelBundle\Command;

use Model\Config\Config;
use Model\Generator\Generator;
use Model\Model;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ModelCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('model:generate')
            ->setDescription('Greet someone')
            ->addArgument(
                'connection',
                InputArgument::REQUIRED,
                'Connection name for generate model'
            )
            ->addOption(
                'erase',
                null,
                InputOption::VALUE_OPTIONAL,
                'Clear output dir after deployment models',
                'y'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generatorConfig = $this->getContainer()->getParameter('model.configuration.generator');
        $connectionName = $input->getArgument('connection');
        
        $db = Model::getDb($connectionName);

        $generatorConfig = array_combine(array_map(function($value) {
            return str_replace('_', '-', $value);
        }, array_keys($generatorConfig)), array_values($generatorConfig));
        $generatorConfig['erase'] = $input->getOption('erase') === 'y';
        $config = new Config($generatorConfig);

        $generator = new Generator($config, $db);
        
        $generator->run();
    }
}