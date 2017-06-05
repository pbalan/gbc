<?php
namespace NalabTnahsarp\VoryxRestTranslationBundle\Annotations\Driver;

use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\MappingException;
use NalabTnahsarp\VoryxRestTranslationBundle\Annotations;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpKernel\Config\FileLocator;

/**
 * Class TranslationTarget
 * @package NalabTnahsarp\VoryxRestTranslationBundle\Annotations\Driver
 */
class TranslationTarget
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $directory;

    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * The Kernel root directory
     * @var string
     */
    private $rootDir;

    /**
     * @var array
     */
    private $targets = [];

    /**
     * @var EntityManager
     */
    private $em;


    /**
     * TranslationTarget constructor.
     *
     * @param $namespace
     *   The namespace of the targets
     * @param $directory
     *   The directory of the targets
     * @param $rootDir
     * @param Reader $annotationReader
     * @param EntityManager $em
     */
    public function __construct($namespace, $directory, $rootDir, Reader $annotationReader, EntityManager $em)
    {
        $this->namespace = $namespace;
        $this->annotationReader = $annotationReader;
        $this->directory = $directory;
        $this->rootDir = $rootDir;
        $this->em = $em;
    }

    /**
     * Returns all the targets
     */
    public function getTargets() {
        if (!$this->targets) {
            $this->discoverTargets();
        }

        return $this->targets;
    }

    /**
     * Discovers targets
     */
    private function discoverTargets() {
        $path = $this->rootDir . '/../src/' . $this->directory;
        $finder = new Finder();
        $finder->files()->in($path);
        $i = 0;
        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $class = $this->namespace . '\\' . $file->getBasename('.php');
            $annotation = $this->annotationReader->getClassAnnotation(new \ReflectionClass($class), 'NalabTnahsarp\VoryxRestTranslationBundle\Annotations\TranslationTarget');
            if (!$annotation) {
                continue;
            }
            $props = [];
            $metaData = $this->em->getClassMetadata($class);
            // check value
            try {
                $properties = $metaData->getFieldNames();
                $exclusions = $this->checkProperty($annotation->getExcluded());
                foreach ($properties as $j => $prop) {
                    if (!in_array($prop, $exclusions)) {
                        array_push($props, [
                            'name' => ucwords(str_replace('_', ' ', strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $prop)))),
                            'prop' => $prop,
                            'values' => null,
                        ]);
                        unset($properties[$j]);
                    }
                }
            } catch (\Exception $ex) {
                throw new \Exception('Exclude property must be an array.');
            }
            try {
                $associations = $metaData->getAssociationMappings();
                $loaders = $this->checkProperty($annotation->loadOptions());
                foreach ($associations as $prop => $association) {
                    if (in_array($prop, $loaders)) {
                        array_push($props, [
                            'name' => ucwords(str_replace('_', ' ', strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $prop)))),
                            'prop' => $prop,
                            'values' => $this->em->getRepository($association['targetEntity'])->findAll(),
                        ]);
                    }
                }
            } catch (\Exception $ex) {
                throw new \Exception('Load options property must be an array.');
            }
            /** @var Annotations\TranslationTarget $annotation */
            $this->targets[$i] = [
                'class' => $class,
                'properties' => $props,
            ];
            $i++;
        }
    }

    /**
     * @throws \Exception
     */
    private function checkProperty(array $val)
    {
        return $val;
    }
}
