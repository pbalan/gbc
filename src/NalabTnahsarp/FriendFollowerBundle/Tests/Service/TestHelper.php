<?php
namespace NalabTnahsarp\FriendFollowerBundle\Tests\Service;

use AppBundle\Entity\User;
use NalabTnahsarp\FriendFollowerBundle\Entity;
use Doctrine\ORM\EntityManager;

/**
 * Class Helper
 * @package NalabTnahsarp\FriendFollowerBundle\Tests\Service
 */
class TestHelper
{
    /** @var \PHPUnit_Framework_MockObject_Generator */
    private $mockGenerator;

    public function __construct()
    {
        $this->mockGenerator = new \PHPUnit_Framework_MockObject_Generator;
    }

    /**
     * @return User|\PHPUnit_Framework_MockObject_MockObject
     */
    public function createUser()
    {
        $this->mockGenerator = new \PHPUnit_Framework_MockObject_Generator;
        return $this->mockGenerator->getMock('AppBundle\Entity\User', [], [], '', false);
    }

    /**
     * @return User|\PHPUnit_Framework_MockObject_MockObject
     */
    public function createFriend()
    {
        $this->mockGenerator = new \PHPUnit_Framework_MockObject_Generator;
        return $this->mockGenerator->getMock('AppBundle\Entity\User', [], [], '', false);
    }
}
