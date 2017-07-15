<?php
namespace AppBundle\Security\Guard;

use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator as BaseAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class JWTAuthenticator
 * @package AppBundle\Security\Guard
 */
class JWTAuthenticator extends BaseAuthenticator
{
    /**
     * Adds a new AuthorizationHeader token extractor for prefixing with "JWT" instead of "Bearer"
     *
     * {@inheritdoc}
     */
    protected function getTokenExtractor()
    {
        $chainExtractor = parent::getTokenExtractor();
        $chainExtractor->addExtractor(new AuthorizationHeaderTokenExtractor('Bearer', 'Authorization'));
        return $chainExtractor;
    }
}
