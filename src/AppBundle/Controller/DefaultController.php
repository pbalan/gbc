<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/{_locale}", defaults={"_locale": "en"}, requirements={
 *     "_locale": "en|zh"
 * })
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("login/check_windows_live", name="windows_live_login")
     */
    public function windowsLiveCheckAction(Request $request)
    {
        dump($request); exit;
        // replace this example code with whatever you need
        return new JsonResponse([
            'data' => $request->getContent()
        ]);
    }
}
