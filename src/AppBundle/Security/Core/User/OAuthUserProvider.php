<?php
namespace AppBundle\Security\Core\User;

use AppBundle\Listener;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Intl\Exception\NotImplementedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserChecker;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class OAuthUserProvider
 * @package AppBundle\Security\Core\User
 */
class OAuthUserProvider extends BaseClass
{
    /**
     * @var Listener\LocaleListener
     */
    private $localeListener;

    /**
     * OAuthUserProvider constructor.
     * @param UserManagerInterface $userManager
     * @param array $properties
     * @param Listener\LocaleListener $localeListener
     */
    public function __construct(
        UserManagerInterface $userManager,
        array $properties,
        Listener\LocaleListener $localeListener
    )
    {
        parent::__construct($userManager, $properties);
        $this->localeListener = $localeListener;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $socialID = $response->getUsername();
        $user = $this->userManager->findUserBy([$this->getProperty($response) => $socialID]);
        $email = $response->getEmail();
        //check if the user already has the corresponding social account
        if (null === $user) {
            //check if the user has a normal account
            $user = $this->userManager->findUserByEmail($email);

            if (null === $user || !$user instanceof UserInterface) {
                //if the user does not have a normal account, set it up:
                $user = $this->userManager->createUser();
                $user->setEmail($email);
                $user->setPlainPassword(md5(uniqid()));
                $user->setEnabled(true);
            }
            //then set its corresponding social id
            $service = $response->getResourceOwner()->getName();
            switch ($service) {
                case 'google':
                    $user->setGoogleId($socialID);
                    break;
                case 'facebook':
                    $user->setFacebookId($socialID);
                    break;
                case 'linkedin':
                    $user->setLinkedInId($socialID);
                    break;
                default:
                    throw new NotImplementedException("A service '{$service}' is not implemented for HWIO Auth in OAuthUserProvider.");
                    break;
            }
            $this->userManager->updateUser($user);
        } else {
            //and then login the user
            $checker = new UserChecker();
            $checker->checkPreAuth($user);
        }

        $user->setLocale($this->localeListener->getCurrentLocale());

        return $user;
    }
}