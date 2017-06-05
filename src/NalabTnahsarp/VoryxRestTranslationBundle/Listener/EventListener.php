<?php
namespace NalabTnahsarp\VoryxRestTranslationBundle\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use NalabTnahsarp\VoryxRestTranslationBundle\Service;
use Gedmo\Translatable\Translatable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * Class EventListener
 * @package NalabTnahsarp\VoryxRestTranslationBundle\Listener
 */
class EventListener implements EventSubscriber
{
    /**
     * @var Service\Translation
     */
    private $translationService;

    /**
     * @var array
     */
    private $namespaces = [];

    /**
     * @var array
     */
    private $insertEntities = [];

    /**
     * @var null|Request
     */
    private $request;

    /**
     * EventListener constructor.
     * @param RequestStack $requestStack
     * @param Service\Translation $translationService
     * @param array $namespaces
     */
    public function __construct(RequestStack $requestStack, Service\Translation $translationService, array $namespaces)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->translationService = $translationService;
        $this->namespaces = $namespaces;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'preFlush',
            'postFlush',
        ];
    }

    /**
     * @param PreFlushEventArgs $event
     */
    public function preFlush(PreFlushEventArgs $event)
    {
        $this->insertEntities = [];
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();

        $insertEntities = $uow->getScheduledEntityInsertions();
        foreach ($insertEntities as $entity) {
            if ($entity instanceof Translatable) {
                $this->insertEntities[] = $entity;
            }
        }
    }

    /**
     * @param PostFlushEventArgs $event
     */
    public function postFlush(PostFlushEventArgs $event)
    {
        foreach ($this->insertEntities as $entity) {
            $this->translationService->addTranslation($this->request, $this->namespaces, $entity);
        }
        unset($entity);
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $this->request = $event->getRequest();
    }
}
