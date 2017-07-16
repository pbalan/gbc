<?php
namespace NalabTnahsarp\FriendFollowerBundle\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * Class CliCommand
 * @package NalabTnahsarp\FriendFollowerBundle\Command
 */
class CliCommand
{
    /**
     * Runs a command in non-interactive mode
     *
     * @param Application $application
     * @param OutputInterface $output
     * @param string $commandName
     * @throws \RuntimeException
     */
    public function run(Application $application, OutputInterface $output, $commandName)
    {
        $command = $application->find($commandName);
        $output->writeln("Running command: {$commandName}");
        $input = new ArrayInput(['command' => $commandName]);
        $input->setInteractive(false);
        $returnCode = $command->run($input, $output);
        if ($returnCode != 0) {
            throw new \RuntimeException("Command '{$commandName}' has returned non-zero exit code.");
        }
    }

    /**
     * Runs a command in non-interactive mode
     *
     * @param Application $application
     * @param OutputInterface $output
     * @param string $commandName
     * @param array $options
     * @throws \RuntimeException
     */
    public function runWithOptions(Application $application, OutputInterface $output, $commandName, array $options)
    {
        $command = $application->find($commandName);
        $output->writeln("Running command: {$commandName}");
        $commandWithOptions = ['command' => $commandName];
        $commandWithOptions = array_merge($commandWithOptions, $options);
        $input = new ArrayInput($commandWithOptions);
        $input->setInteractive(false);
        $returnCode = $command->run($input, $output);
        if ($returnCode != 0) {
            throw new \RuntimeException("Command '{$commandName}' has returned non-zero exit code.");
        }
    }
}
