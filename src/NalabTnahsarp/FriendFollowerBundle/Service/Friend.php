<?php
namespace NalabTnahsarp\FriendFollowerBundle\Service;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use NalabTnahsarp\FriendFollowerBundle\Entity;

/**
 * Class Friend
 * @package NalabTnahsarp\FriendFollowerBundle\Service
 */
class Friend
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var User
     */
    private $user;

    /**
     * @var User
     */
    private $friend;

    /**
     * @var Entity\Friend|null
     */
    private $isFriendWaiting = null;

    /**
     * @var Entity\Friend|null
     */
    private $existingFriend = null;

    /**
     * @var string
     */
    private $status = Entity\Friend::FRIEND_ADD_STATUS_FAILED;

    /**
     * Friend constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param User $user
     * @param User $friend
     * @return string
     */
    public function addFriend(User $user, User $friend)
    {
        try {
            $this->user = $user;
            $this->friend = $friend;
            $this->isPendingRequest();
            if (!$this->isFriendWaiting) {
                $entity = new Entity\Friend($this->user, $this->friend);
                $entity->setIsPending(Entity\Friend::FRIEND_IS_PENDING_YES);
                $entity->setIsDeleted(Entity\Friend::FRIEND_IS_DELETED_NO);
                $this->em->persist($entity);
                $this->setStatus(Entity\Friend::FRIEND_ADD_STATUS_PENDING);
                return $entity;
            } else {
                $entity = new Entity\Friend($this->user, $this->friend);
                $entity->setIsPending(Entity\Friend::FRIEND_IS_PENDING_NO);
                $entity->setIsDeleted(Entity\Friend::FRIEND_IS_DELETED_NO);
                $this->isFriendWaiting->setIsPending(Entity\Friend::FRIEND_IS_PENDING_NO);
                $this->em->persist($entity);
                $this->em->persist($this->isFriendWaiting);
                $this->setStatus(Entity\Friend::FRIEND_ADD_STATUS_COMPLETED);
                return $entity;
            }
        } catch (\Exception $ex) {
            // no exception thrown as status must be returned
        }
    }

    /**
     * @param User $user
     * @param User $friend
     * @return string
     */
    public function removeFriend(User $user, User $friend)
    {
        try {
            $this->user = $user;
            $this->friend = $friend;
            $entity = new Entity\Friend($this->user, $this->friend);
            $entity->setIsPending(Entity\Friend::FRIEND_IS_PENDING_NO);
            $entity->setIsDeleted(Entity\Friend::FRIEND_IS_DELETED_YES);
            $this->em->persist($entity);
            if ($this->existingFriend) {
                $this->existingFriend->setIsPending(Entity\Friend::FRIEND_IS_PENDING_NO);
                $this->existingFriend->setIsDeleted(Entity\Friend::FRIEND_IS_DELETED_YES);
                $this->em->persist($this->existingFriend);
            }
            return Entity\Friend::FRIEND_REMOVE_COMPLETED;
        } catch (\Exception $ex) {
            return Entity\Friend::FRIEND_REMOVE_FAILED;
        }
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $status
     */
    private function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Check if a friend is waiting for approval
     */
    private function isPendingRequest()
    {
        $criteria = [
            'friend' => $this->user,
            'user' => $this->friend,
        ];
        $orderBy = [
            'createdAt' => 'DESC',
        ];
        $this->existingFriend = $this->isFriendWaiting =
            $this->em->getRepository('FriendFollowerBundle:Friend')->findOneBy($criteria, $orderBy);
        if ($this->isFriendWaiting && $this->isFriendWaiting->getIsPending() === Entity\Friend::FRIEND_IS_PENDING_NO) {
            $this->isFriendWaiting = null;
        }
    }

    /**
     * @param array $formData
     * @throws \DomainException
     */
    private function validate(array $formData)
    {
        if (false === isset($formData['user']) || true === empty($formData['user'])) {
            throw new \DomainException('User ID must not be empty.');
        }
        if (false === isset($formData['friend']) || true === empty($formData['friend'])) {
            throw new \DomainException('Friend ID must not be empty.');
        }
    }
}
