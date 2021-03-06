<?php
namespace AppBundle\Controller;

use AppBundle\Entity\University;
use AppBundle\Entity\Translation;
use AppBundle\Form\UniversityType;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View as FOSView;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Voryx\RESTGeneratorBundle\Controller\VoryxController;

/**
 * University controller.
 * @RouteResource("University")
 */
class UniversityRESTController extends VoryxController
{
    /**
     * Get a University entity
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param University $entity
     *
     * @return University
     *
     */
    public function getAction(University $entity)
    {
        return $entity;
    }

    /**
     * Get all University entities.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get all universities"
     * )
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return University[]|FOSView
     *
     * @QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing notes.")
     * @QueryParam(name="limit", requirements="\d+", default="20", description="How many notes to return.")
     * @QueryParam(name="order_by", nullable=true, array=true, description="Order by fields. Must be an array ie. &order_by[name]=ASC&order_by[description]=DESC")
     * @QueryParam(name="filters", nullable=true, array=true, description="Filter by fields. Must be an array ie. &filters[id]=3")
     */
    public function cgetAction(ParamFetcherInterface $paramFetcher)
    {
        try {
            $offset = $paramFetcher->get('offset');
            $limit = $paramFetcher->get('limit');
            $order_by = $paramFetcher->get('order_by');
            $filters = !is_null($paramFetcher->get('filters')) ? $paramFetcher->get('filters') : [];

            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('AppBundle:University')->findBy($filters, $order_by, $limit, $offset);
            if ($entities) {
                return $entities;
            }

            return FOSView::create('Not Found', Codes::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create a University entity.
     *
     * @ApiDoc(
     *  description="Create a new university",
     *  input="AppBundle\Form\UniversityType",
     *  output="AppBundle\Entity\University"
     * )
     *
     * @View(statusCode=201, serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     *
     * @return University|FOSView
     *
     */
    public function postAction(Request $request)
    {
        $entity = new University();
        $form = $this->createForm(get_class(new UniversityType()), $entity, ["method" => $request->getMethod()]);
        $this->removeExtraFields($request, $form);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $entity;
        }

        return FOSView::create(['errors' => $form->getErrors()], Codes::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Update a University entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param University $entity
     *
     * @return University|FOSView
     */
    public function putAction(Request $request, University $entity)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $request->setMethod('PATCH'); //Treat all PUTs as PATCH
            $form = $this->createForm(get_class(new UniversityType()), $entity, ["method" => $request->getMethod()]);
            $this->removeExtraFields($request, $form);
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();

                return $entity;
            }

            return FOSView::create(['errors' => $form->getErrors()], Codes::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Partial Update to a University entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param University $entity
     *
     * @return University|FOSView
     */
    public function patchAction(Request $request, University $entity)
    {
        return $this->putAction($request, $entity);
    }

    /**
     * Delete a University entity.
     *
     * @View(statusCode=204)
     *
     * @param Request $request
     * @param $entity
     *
     * @return FOSView|null
     */
    public function deleteAction(Request $request, University $entity)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();

            return null;
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
