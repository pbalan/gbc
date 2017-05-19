<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="gbc_users")
 *  @ORM\AttributeOverrides({
 *     @ORM\AttributeOverride(name="username",
 *          column=@ORM\Column(
 *              nullable = true
 *          )
 *      ),
 *     @ORM\AttributeOverride(name="usernameCanonical",
 *          column=@ORM\Column(
 *              name = "username_canonical",
 *              nullable = true
 *          )
 *      ),
 *     @ORM\AttributeOverride(name="email",
 *          column=@ORM\Column(
 *              nullable = true
 *          )
 *      ),
 *     @ORM\AttributeOverride(name="emailCanonical",
 *          column=@ORM\Column(
 *              name = "email_canonical",
 *              nullable = true
 *          )
 *      )
 * })
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="locale", type="string", nullable=false, options={"default" : "en"})
     */
    private $locale = "en";

    /**
     * @var string
     * @ORM\Column(name="intl_code", type="string", nullable=true)
     */
    private $intlCode;

    /**
     * @var string
     * @ORM\Column(name="mobile_number", type="string", nullable=true)
     */
    private $mobileNumber;

    /**
     * @var string
     * @ORM\Column(name="facebook_id", type="string", nullable=true)
     */
    private $facebookId;

    /**
     * @var string
     * @ORM\Column(name="google_id", type="string", nullable=true)
     */
    private $googleId;

    /**
     * @var string
     * @ORM\Column(name="linkedin_id", type="string", nullable=true)
     */
    private $linkedInId;

    /**
     * @var string
     * @ORM\Column(name="wechat_id", type="string", nullable=true)
     */
    private $wechatId;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return string
     */
    public function getIntlCode()
    {
        return $this->intlCode;
    }

    /**
     * @param string $intlCode
     */
    public function setIntlCode($intlCode)
    {
        $this->intlCode = $intlCode;
    }

    /**
     * @return string
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    /**
     * @param string $mobileNumber
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param string $facebookId
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    }

    /**
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * @param string $googleId
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;
    }

    /**
     * @return string
     */
    public function getLinkedInId()
    {
        return $this->linkedInId;
    }

    /**
     * @param string $linkedInId
     */
    public function setLinkedInId($linkedInId)
    {
        $this->linkedInId = $linkedInId;
    }

    /**
     * @return string
     */
    public function getWechatId()
    {
        return $this->wechatId;
    }

    /**
     * @param string $wechatId
     */
    public function setWechatId($wechatId)
    {
        $this->wechatId = $wechatId;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale = "en")
    {
        $this->locale = $locale;
    }
}
