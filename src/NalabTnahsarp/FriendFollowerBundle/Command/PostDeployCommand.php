<?php
namespace NalabTnahsarp\FriendFollowerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use NalabTnahsarp\FriendFollowerBundle\Command\CliCommand;
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\Bundle\MigrationsBundle\Command\DoctrineCommand;

/**
 * Class PostDeployCommand
 * @package NalabTnahsarp\FriendFollowerBundle\Command
 */
class PostDeployCommand extends ContainerAwareCommand
{
    /** @inheritdoc */
    protected function configure()
    {
        $this->setName('friendfollower:postdeploy')->setDescription('Post-deploy commands.');
    }

    /** @inheritdoc */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $runner = new CliCommand;
        $config = $this->createMigrationConfig();
        $runner->run($this->getApplication(), $output, 'doctrine:migrations:status');
        $runner->run($this->getApplication(), $output, 'doctrine:migrations:diff');
        $runner->run($this->getApplication(), $output, 'doctrine:migrations:migrate');
    }

    /**
     * A factory method for creating doctrine migration config
     *
     * @return Configuration
     */
    private function createMigrationConfig()
    {
        $container = $this->getContainer();
        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $container->get('doctrine.dbal.default_connection');
        $config = new Configuration($connection);
        DoctrineCommand::configureMigrations($container, $config);
        return $config;
    }
}
