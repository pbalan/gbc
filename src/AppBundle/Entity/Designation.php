<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\Designation")
 * @ORM\Table(name="designations")
 */
class Designation
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false, name="name")
     */
    private $name;

    /**
     * @ORM\OneToMany(
     *   targetEntity="AppBundle\Entity\Translation\Designation",
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * Designation constructor.
     */
    public function __construct()
    {
        $this->translations = new ArrayCollection;
    }

    /**
     * @return ArrayCollection
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param Translation\Designation $t
     */
    public function addTranslation(Translation\Designation $t)
    {
        if (!$this->translations->contains($t)) {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
