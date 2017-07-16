<?php
namespace NalabTnahsarp\FriendFollowerBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use NalabTnahsarp\FriendFollowerBundle\Service\Helper\Time;

/**
 * Follower
 *
 * @ORM\Table(name="followers",
 *     options={
 *         "charset":"utf8",
 *         "collate":"utf8_general_ci",
 *         "comment":"stores follower of user.",
 *         "temporary":false,
 *         "engine":"InnoDB"
 *     },
 *     indexes={
 *         @ORM\Index(name="IDX_FOLLOWER_USER_ID", columns={"user_id"}),
 *         @ORM\Index(name="IDX_FOLLOWER_IS_UNFOLLOWED", columns={"is_unfollowed"}),
 *         @ORM\Index(name="IDX_FOLLOWER_CREATED_AT", columns={"created_at"})
 *     }
 * )
 * @ORM\Entity
 */
class Follower
{
    const FOLLOWER_IS_UNFOLLOWED_YES = 'Yes';
    const FOLLOWER_IS_UNFOLLOWED_NO = 'No';

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
     *     name="follower_id",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $follower;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="is_unfollowed", type="string", length=3, options={"default": "No"})
     */
    private $isUnfollowed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="un_followed_at", type="datetime", nullable=true)
     */
    private $unFollowedAt;

    /**
     * Follower constructor.
     * @param User $follower
     * @param User $user
     */
    public function __construct(User $follower, User $user)
    {
        $this->setFollower($follower);
        $this->setUser($user);
        if (!$this->getCreatedAt()) {
            $this->setCreatedAt(Time::getUtcTime());
        }
        if (!$this->getIsUnfollowed()) {
            $this->setIsUnfollowed(self::FOLLOWER_IS_UNFOLLOWED_NO);
        }
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
     * @return Follower
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
     * Set follower
     *
     * @param User $follower
     *
     * @return Follower
     */
    public function setFollower(User $follower)
    {
        $this->follower = $follower;

        return $this;
    }

    /**
     * Get follower
     *
     * @return User
     */
    public function getFollower()
    {
        return $this->follower;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Follower
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
     * Set isUnfollowed
     *
     * @param string $isUnfollowed
     *
     * @return Follower
     */
    public function setIsUnfollowed($isUnfollowed)
    {
        $this->isUnfollowed = $isUnfollowed;

        return $this;
    }

    /**
     * Get isUnfollowed
     *
     * @return string
     */
    public function getIsUnfollowed()
    {
        return $this->isUnfollowed;
    }

    /**
     * Set unFollowedAt
     *
     * @param \DateTime $unFollowedAt
     *
     * @return Follower
     */
    public function setUnFollowedAt(\DateTime $unFollowedAt)
    {
        $this->unFollowedAt = $unFollowedAt;

        return $this;
    }

    /**
     * Get unFollowedAt
     *
     * @return \DateTime
     */
    public function getUnFollowedAt()
    {
        return $this->unFollowedAt;
    }
}
