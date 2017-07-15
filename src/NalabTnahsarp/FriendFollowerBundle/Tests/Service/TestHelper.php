<?php
namespace Tests\Service;

use AppBundle\Entity\User;

/**
 * Class Helper
 * @package Tests\Service
 */
class Helper extends \PHPUnit_Framework_TestCase
{
    /** @var User|PhpMoc */
    private static $user;

    private $friend;

    public static function createUser()
    {
        self::$user = self::getMockBuilder('AppBundle\Entity\User')
            ->getMock();
    }
}
