<?php
namespace NalabTnahsarp\FriendFollowerBundle\Controller;

use AppBundle\AppBundle;
use Doctrine\ORM\EntityManager;
use NalabTnahsarp\FriendFollowerBundle\Entity;
use NalabTnahsarp\FriendFollowerBundle\Service;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FriendController
 * @package NalabTnahsarp\FriendFollowerBundle\Controller
 */
class FriendController extends AbstractController
{
    /**
     * @var Service\Friend
     */
    private $friendService;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager
     */
    private $jwtManager;

    /**
     * @var \AppBundle\Security\Guard\JWTAuthenticator
     */
    private $jwtAuthenticator;

    /** {@inheritdoc} */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->friendService = $this->get('friend_follower.friend');
        $this->entityManager = $this->getDoctrine()->getEntityManager();
        $this->jwtManager = $this->get('lexik_jwt_authentication.jwt_manager');
        $this->jwtAuthenticator = $this->get('app.jwt_token_authenticator');
    }

    /**
     * @Route("/friend/add", name="friend-add")
     * @param Request $request
     * @return JsonResponse
     */
    public function addFriendAction(Request $request)
    {
        $response = [
            'status' => self::RESPONSE_OK,
            'msg' => self::RESPONSE_MESSAGE_SUCCESS,
        ];
        $formData = json_decode($request->getContent(), true);
        $this->entityManager->transactional(function () use ($formData, &$response, $request) {
            $preAuthToken = $this->jwtAuthenticator->getCredentials($request);
            $response['preAuth'] = $preAuthToken;
            $userFromToken = $this->jwtManager->decode($preAuthToken);
            /** @var \AppBundle\Entity\User $user */
            $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($userFromToken['id']);
            /** @var \AppBundle\Entity\User $friend */
            $friend = $this->getDoctrine()->getRepository('AppBundle:User')->find($formData['friend']);
            $this->friendService->addFriend($user, $friend);
            $response['msg'] = $this->friendService->getStatus();
        });
        return new JsonResponse($response);
    }

    /**
     * @Route("/friend/remove", name="friend-remove")
     * @param Request $request
     * @return JsonResponse
     */
    public function unFriendAction(Request $request)
    {
        $response = [
            'status' => self::RESPONSE_OK,
            'msg' => self::RESPONSE_MESSAGE_SUCCESS,
        ];
        $formData = json_decode($request->getContent(), true);
        $this->entityManager->transactional(function () use ($formData, &$response) {
            /** @var $user */
            $user = $this->get('security.context')->getToken()->getUser();
            return new JsonResponse(['resp' => $user]);
            /** @var \AppBundle\Entity\User $friend */
            $friend = $this->getDoctrine()->getRepository('AppBundle:User')->find($formData['friend']);
            $removeStatus = $this->friendService->removeFriend($user, $friend);
            $response['msg'] = $removeStatus;
        });
        return new JsonResponse($response);
    }
}
