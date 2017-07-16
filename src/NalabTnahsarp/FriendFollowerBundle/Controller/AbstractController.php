<?php
namespace NalabTnahsarp\FriendFollowerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class AbstractController
 * @package NalabTnahsarp\FriendFollowerBundle\Controller
 */
class AbstractController extends Controller
{
    const RESPONSE_OK = 'OK';
    const RESPONSE_ERROR = 'ERROR';
    const RESPONSE_MESSAGE_SUCCESS = 'SUCCESS';
    const RESPONSE_MESSAGE_FAIL = 'FAIL';
}
