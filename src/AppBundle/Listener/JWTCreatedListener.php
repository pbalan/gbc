<?php
namespace AppBundle\Listener;

use AppBundle\Entity;
use AppBundle\Service;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class JWTCreatedListener
 * @package AppBundle\Listener
 */
class JWTCreatedListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Service\UserDetail
     */
    private $userDetailService;

    /**
     * @param RequestStack $requestStack
     * @param Service\UserDetail $userDetailService
     */
    public function __construct(RequestStack $requestStack, Service\UserDetail $userDetailService)
    {
        $this->requestStack = $requestStack;
        $this->userDetailService = $userDetailService;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        $payload       = $event->getData();
        /** @var Entity\UserDetail $userDetail */
        $userDetail = $this->userDetailService->getPublicUserDetail($event->getUser()->getUsername())->getScalarResult();
        $payload['name'] = sprintf('%s %s', $userDetail[0]['firstName'], $userDetail[0]['lastName']);
        $payload['id'] = $userDetail[0]['id'];
        $payload['firstname'] = $userDetail[0]['firstName'];
        $payload['lastname'] = $userDetail[0]['lastName'];
        $payload['ip'] = $request->getClientIp();

        $event->setData($payload);
    }
}
