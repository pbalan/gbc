<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Form\CompanyType;

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
 * Company controller.
 * @RouteResource("Company")
 */
class CompanyRESTController extends VoryxController
{
    /**
     * Get a Company entity
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Company $entity
     *
     * @return Company|FOSView
     *
     */
    public function getAction(Company $entity)
    {
        return $entity;
    }

    /**
     * Get all Company entities.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get all companies"
     * )
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return Company[]|FOSView
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
            $entities = $em->getRepository('AppBundle:Company')->findBy($filters, $order_by, $limit, $offset);
            if ($entities) {
                return $entities;
            }

            return FOSView::create('Not Found', Codes::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create a Company entity.
     *
     * @ApiDoc(
     *  description="Create a new company",
     *  input="AppBundle\Form\CompanyType",
     *  output="AppBundle\Entity\Company"
     * )
     *
     * @View(statusCode=201, serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     *
     * @return Company|FOSView
     *
     */
    public function postAction(Request $request)
    {
        $entity = new Company();
        $form = $this->createForm(get_class(new CompanyType()), $entity, ["method" => $request->getMethod()]);
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
     * Update a Company entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param Company $entity
     *
     * @return Company|FOSView
     */
    public function putAction(Request $request, Company $entity)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $request->setMethod('PATCH'); //Treat all PUTs as PATCH
            $form = $this->createForm(get_class(new CompanyType()), $entity, ["method" => $request->getMethod()]);
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
     * Partial Update to a Company entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param Company $entity
     *
     * @return Company|FOSView
     */
    public function patchAction(Request $request, Company $entity)
    {
        return $this->putAction($request, $entity);
    }

    /**
     * Delete a Company entity.
     *
     * @View(statusCode=204)
     *
     * @param Request $request
     * @param Company $entity
     *
     * @return null|FOSView
     */
    public function deleteAction(Request $request, Company $entity)
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
