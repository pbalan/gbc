<?php
namespace NalabTnahsarp\FriendFollowerBundle\Tests\Service;

use NalabTnahsarp\FriendFollowerBundle\Entity;
use NalabTnahsarp\FriendFollowerBundle\Service\Friend as FriendService;

/**
 * Class FriendTest
 * @package NalabTnahsarp\FriendFollowerBundle\Tests\Service
 */
class FriendTest extends \PHPUnit_Framework_TestCase
{
    /** @var \AppBundle\Entity\User|\PHPUnit_Framework_MockObject_MockObject */
    private $user;

    /** @var \AppBundle\Entity\User|\PHPUnit_Framework_MockObject_MockObject */
    private $friend;

    /** @var TestHelper */
    private static $helper;

    /** @inheritdoc */
    public static function setUpBeforeClass()
    {
        self::$helper = new TestHelper;
    }

    /** @inheritdoc */
    protected function setUp()
    {
        parent::setUp();
        $this->user = self::$helper->createUser();
        $this->friend = self::$helper->createFriend();
    }

    /**
     * Test add friend when not pending
     */
    public function testAddFriendNotPending()
    {
        $entityManager = $this->getEntityManager();
        $friendAddRequest = new FriendService($entityManager);
        $friendAddRequest->addFriend($this->user, $this->friend);
        $response = $friendAddRequest->getStatus();
        $this->assertEquals(Entity\Friend::FRIEND_ADD_STATUS_PENDING, $response);
    }

    /**
     * Test add friend when friend pending
     */
    public function testAddFriendPending()
    {
        $friendEntity = new Entity\Friend($this->friend, $this->user);
        $entityManager = $this->getEntityManager($friendEntity);
        $pendingRequest = new FriendService($entityManager);
        /** @var Entity\Friend $lastInsert */
        $lastInsert = $pendingRequest->addFriend($this->friend, $this->user);
        $lastInsert->setId(1);
        $friendAddRequest = new FriendService($entityManager);
        $friendAddRequest->addFriend($this->user, $this->friend);
        $response = $friendAddRequest->getStatus();
        $this->assertEquals(Entity\Friend::FRIEND_ADD_STATUS_COMPLETED, $response);
    }

    /**
     * @param Entity\Friend|null $friendEntity
     * @return \Doctrine\ORM\EntityManager|\PHPUnit_Framework_MockObject_MockObject
     */
    public function getEntityManager(Entity\Friend $friendEntity = null)
    {
        $repository = $this
            ->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods(['findBy'])
            ->getMock();
        $repository
            ->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue(null));

        /** @var \Doctrine\ORM\EntityManager|\PHPUnit_Framework_MockObject_MockObject $entityManager */
        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->setMethods(['getRepository', 'getUnitOfWork', 'persist'])
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager
            ->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($repository));
        $entityManager
            ->expects($this->any())
            ->method('getUnitOfWork')
            ->will($this->returnValue($repository));
        $entityManager
            ->expects($this->any())
            ->method('persist')
            ->with($friendEntity)
            ->will($this->returnValue(null));
        return $entityManager;
    }

    /** @inheritdoc */
    protected function tearDown()
    {
        parent::tearDown();
        unset($this->user);
        unset($this->friend);
    }
}
