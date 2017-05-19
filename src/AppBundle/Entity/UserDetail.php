<?php
namespace AppBundle\Entity;

use AppBundle\AppBundle;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_details")
 */
class UserDetail
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\User",
     *     inversedBy="detail"
     * )
     * @ORM\JoinColumn(
     *     name="user_id",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false, name="first_name")
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false, name="last_name")
     */
    private $lastName;

    /**
     * @var Designation
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Designation"
     * )
     * @ORM\JoinColumn(
     *     name="designation_id",
     *     referencedColumnName="id",
     *     nullable=true
     * )
     */
    private $designation;

    /**
     * @var Company
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Company"
     * )
     * @ORM\JoinColumn(
     *     name="company_id",
     *     referencedColumnName="id",
     *     nullable=true
     * )
     */
    private $company;

    /**
     * @var University
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\University"
     * )
     * @ORM\JoinColumn(
     *     name="university_id",
     *     referencedColumnName="id"
     * )
     */
    private $university;

    /**
     * UserDetail constructor.
     * @param User $user
     * @param $firstName
     * @param $lastName
     * @param Designation|null $designation
     * @param Company|null $company
     * @param University|null $university
     */
    public function __construct(
        User $user,
        $firstName,
        $lastName,
        Designation $designation = null,
        Company $company = null,
        University $university = null
    ) {
        $this->setUser($user);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setDesignation($designation);
        $this->setCompany($company);
        $this->setUniversity($university);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return Designation
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * @param Designation|null $designation
     */
    public function setDesignation($designation = null)
    {
        $this->designation = $designation;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param Company|null $company
     */
    public function setCompany($company = null)
    {
        $this->company = $company;
    }

    /**
     * @return University
     */
    public function getUniversity()
    {
        return $this->university;
    }

    /**
     * @param University|null $university
     */
    public function setUniversity($university = null)
    {
        $this->university = $university;
    }
}
