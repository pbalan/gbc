<?php
namespace AppBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="university_translations",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_UNIVERSITY_TRANSLATION", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class University extends AbstractPersonalTranslation
{
    /**
     * Convenient constructor
     *
     * @param string $locale
     * @param string $field
     * @param string $value
     */
    public function __construct($locale, $field, $value)
    {
        $this->setLocale($locale);
        $this->setField($field);
        $this->setContent($value);
    }

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\University", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}
