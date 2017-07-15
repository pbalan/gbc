<?php
namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Class UserDetail
 * @package AppBundle\Service
 */
class UserDetail
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * UserDetail constructor.
     * @param EntityManager $em\
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $username
     * @return \Doctrine\ORM\Query
     */
    public function getPublicUserDetail($username)
    {
        $query = $this->em->createQuery('
            SELECT u.id, ud.firstName, ud.lastName
            FROM AppBundle\Entity\UserDetail ud
            INNER JOIN AppBundle\Entity\User u WITH u.id = ud.user AND u.username = ?0
        ');
        $query->setParameter(0, $username);

        return $query;
    }
}
