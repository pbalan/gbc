<?php
namespace NalabTnahsarp\FriendFollowerBundle\Composer;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;
use NalabTnahsarp\FriendFollowerBundle\Service\InstallationService;

/**
 * Class ScriptHandler
 * @package NalabTnahsarp\FriendFollowerBundle\Composer
 */
class ScriptHandler
{
    private static $saveEnvironments = ['dev'];

    /**
     * Composer hook for running post install tasks
     * @param Event $event
     */
    public static function postInstall(Event $event)
    {
        $io = $event->getIO();

        $io->write('-----------------------------------');
        $io->write(' FriendFollowerBundle Post Install ');
        $io->write('-----------------------------------');

        $env = self::getEnvironment();

        if (!in_array($env, self::$saveEnvironments)) {
            $io->write('Post install will not be executed outside a safe environment.');
        }

        $rootDir = getcwd();

        /** @var InstallationService $installation */
        $installation = new InstallationService($rootDir);

        $io->write('Running migrations...');
        if ($installation->executeMigrations()) {
            $io->write('Generated migrations...');
        } else {
            $io->write('An error occurred while generating migrations.');
            exit;
        }

        $io->write('ContentManagerBundle post-install complete...');
    }

    /**
     * Composer hook for running post install tasks
     * @param Event $event
     */
    public static function postUpdate(Event $event)
    {
        $io = $event->getIO();

        $io->write('----------------------------------');
        $io->write(' FriendFollowerBundle Post Update ');
        $io->write('----------------------------------');

        $env = self::getEnvironment();

        if (!in_array($env, self::$saveEnvironments)) {
            $io->write('Post update will not be executed outside a safe environment.');
        }

        $rootDir = getcwd();

        /** @var InstallationService $installation */
        $installation = new InstallationService($rootDir);

        $io->write('Running migrations...');
        if ($installation->executeMigrations()) {
            $io->write('Generated migrations...');
        } else {
            $io->write('An error occurred while generating migrations.');
            exit;
        }

        $io->write('ContentManagerBundle post-update complete...');
    }

    /**
     * @return array|false|string
     */
    private static function getEnvironment()
    {
        return getenv('SYMFONY_ENV');
    }
}
