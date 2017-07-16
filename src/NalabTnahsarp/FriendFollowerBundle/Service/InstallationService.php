<?php
namespace NalabTnahsarp\FriendFollowerBundle\Service;

use Symfony\Component\Process\Process;

/**
 * Class InstallationService
 * @package NalabTnahsarp\FriendFollowerBundle\Service
 */
class InstallationService
{
    /**
     * @var string
     */
    private $rootDir;

    /**
     * @var string
     */
    private $bowerPath;

    /**
     * InstallationService constructor.
     *
     * @param $rootDir
     */
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
        $this->bowerPath = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
    }

    /**
     * @return bool
     */
    public function resolveDependencies()
    {
        try {
            $process = new Process('bower install', $this->bowerPath);
            $process->mustRun();
            echo $process->getOutput();
            return true;
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    /**
     * @return bool
     */
    public function dumpAssets()
    {
        try {
            $process = new Process('php app/console asset:install', $this->rootDir);
            $process->mustRun();
            echo $process->getOutput();
            return true;
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    /**
     * @return bool
     */
    public function executeMigrations()
    {
        try {
            $process = new Process('php app/console friendfollower:postdeploy', $this->rootDir);
            $process->mustRun();
            echo $process->getOutput();
            return true;
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
}
