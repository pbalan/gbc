<?php
namespace NalabTnahsarp\FriendFollowerBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use NalabTnahsarp\FriendFollowerBundle\Service\Helper\Time;

/**
 * Friend
 *
 * @ORM\Table(name="friends",
 *     options={
 *         "charset":"utf8",
 *         "collate":"utf8_general_ci",
 *         "comment":"stores friends of user.",
 *         "temporary":false,
 *         "engine":"InnoDB"
 *     },
 *     indexes={
 *         @ORM\Index(name="IDX_FRIEND_USER_ID", columns={"user_id"}),
 *         @ORM\Index(name="IDX_FRIEND_IS_DELETED", columns={"is_deleted"}),
 *         @ORM\Index(name="IDX_FRIEND_CREATED_AT", columns={"created_at"})
 *     }
 * )
 * @ORM\Entity
 */
class Friend
{
    const FRIEND_ADD_STATUS_COMPLETED = 'Completed';
    const FRIEND_ADD_STATUS_PENDING = 'Pending';
    const FRIEND_ADD_STATUS_FAILED = 'Failed';

    const FRIEND_REMOVE_COMPLETED = 'Completed';
    const FRIEND_REMOVE_FAILED = 'Failed';

    const FRIEND_IS_PENDING_YES = 'Yes';
    const FRIEND_IS_PENDING_NO = 'No';

    const FRIEND_IS_DELETED_YES = 'Yes';
    const FRIEND_IS_DELETED_NO = 'No';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\User"
     * )
     * @ORM\JoinColumn(
     *     name="user_id",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $user;

    /**
     * @var User
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\User"
     * )
     * @ORM\JoinColumn(
     *     name="friend_id",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $friend;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(
     *     name="is_pending",
     *     type="string",
     *     length=3,
     *     options={"comment": "A user must accept friend request until then its pending.", "default": "Yes"}
     * )
     */
    private $isPending;

    /**
     * @var string
     *
     * @ORM\Column(
     *     name="is_deleted",
     *     type="string",
     *     length=3,
     *     options={"comment": "Record soft/hard break-ups in relationship.", "default": "No"}
     *  )
     */
    private $isDeleted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(
     *     name="deleted_at",
     *     type="datetime",
     *     nullable=true,
     *     options={"comment": "Record when the friendship got affected."}
     * )
     */
    private $deletedAt;

    /**
     * Friend constructor.
     * @param User $user
     * @param User $friend
     */
    public function __construct(User $user, User $friend)
    {
        $this->setUser($user);
        $this->setFriend($friend);
        if (!$this->getCreatedAt()) {
            $this->setCreatedAt(Time::getUtcTime());
        }
    }

    /**
     * Set id
     *
     * @param int $id
     *
     * @return Friend
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Friend
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set friend
     *
     * @param User $friend
     *
     * @return Friend
     */
    public function setFriend(User $friend)
    {
        $this->friend = $friend;

        return $this;
    }

    /**
     * Get friend
     *
     * @return User
     */
    public function getFriend()
    {
        return $this->friend;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Friend
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set isPending
     *
     * @param string $isPending
     *
     * @return Friend
     */
    public function setIsPending($isPending)
    {
        $this->isPending = $isPending;

        return $this;
    }

    /**
     * Get isPending
     *
     * @return string
     */
    public function getIsPending()
    {
        return $this->isPending;
    }

    /**
     * Set isDeleted
     *
     * @param string $isDeleted
     *
     * @return Friend
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return string
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime|null $deletedAt
     *
     * @return Friend
     */
    public function setDeletedAt(\DateTime $deletedAt = null)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}
