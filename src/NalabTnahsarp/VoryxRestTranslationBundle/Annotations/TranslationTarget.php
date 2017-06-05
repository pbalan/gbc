<?php
namespace NalabTnahsarp\VoryxRestTranslationBundle\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"CLASS", "PROPERTY"})
 */
final class TranslationTarget extends Annotation
{
    /**
     * @var array
     */
    public $exclude;

    /**
     * @var array
     */
    public $load;

    /**
     * @return array
     */
    public function getExcluded()
    {
        return $this->exclude;
    }

    public function loadOptions()
    {
        return $this->load;
    }
}
