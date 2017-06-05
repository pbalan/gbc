<?php
namespace NalabTnahsarp\VoryxRestTranslationBundle\Service;

use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class Translation
 * @package NalabTnahsarp\VoryxRestTranslationBundle\Service
 */
class Translation
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * @var array
     */
    private $locales = ['en'];

    /**
     * Translation constructor.
     * @param EntityManager $em
     * @param Reader $annotationReader
     * @param array $locales
     */
    public function __construct(EntityManager $em, Reader $annotationReader, array $locales)
    {
        $this->em = $em;
        $this->annotationReader = $annotationReader;
        $this->locales = $locales;
    }

    /**
     * @param Request $request
     * @param array $namespaces
     * @param object $entity
     * @throws \Exception
     */
    public function addTranslation(Request $request, array $namespaces, $entity)
    {
        $class = get_class($entity);
        $annotations = $this->annotationReader->getClassAnnotation(new \ReflectionClass($class), 'Gedmo\Mapping\Annotation\TranslationEntity');
        $translationClass = $annotations->class;
        $properties = $this->getProperties($entity);

        // ensure default locale exists in the list of specified locales
        if (!in_array($request->getDefaultLocale(), $this->locales)) {
            array_push($this->locales, $request->getDefaultLocale());
        }

        $this->em->transactional(function () use ($request, $entity, $namespaces, $properties, $translationClass) {
            try {
                if (in_array($this->getNamespace($entity), $namespaces) && $translationClass != '') {
                    foreach ($properties as $property) {
                        if ($property == 'id') {
                            continue;
                        }
                        // add same translation for all locales
                        foreach ($this->locales as $locale) {
                            if ($locale === $request->getDefaultLocale()) {
                                continue;
                            }
                            $entity->addTranslation(
                                new $translationClass(
                                    $locale,
                                    $property,
                                    $request->request->get($property)
                                )
                            );
                        }
                    }
                    $this->em->persist($entity);
                }
            } catch (\Exception $ex) {
                throw new \Exception(sprintf("Unable to add translation for Entity: %s", get_class($entity)));
            }
        });
    }

    /**
     * @param string $entity
     * @return array
     */
    private function getProperties($entity)
    {
        return $this->em->getClassMetadata(get_class($entity))->getFieldNames();
    }

    /**
     * @param object $entity
     * @return string
     */
    private function getNamespace($entity)
    {
        $reflect = new \ReflectionClass(get_class($entity));
        return $reflect->getNamespaceName();
    }
}
