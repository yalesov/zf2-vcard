<?php

namespace Heartsentwined\Vcard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Heartsentwined\Vcard\Entity\GenderValue
 */
class GenderValue
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $value
     */
    private $value;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $genders;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->genders = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return GenderValue
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Add genders
     *
     * @param Heartsentwined\Vcard\Entity\Gender $genders
     * @return GenderValue
     */
    public function addGender(\Heartsentwined\Vcard\Entity\Gender $genders)
    {
        $this->genders[] = $genders;
    
        return $this;
    }

    /**
     * Remove genders
     *
     * @param Heartsentwined\Vcard\Entity\Gender $genders
     */
    public function removeGender(\Heartsentwined\Vcard\Entity\Gender $genders)
    {
        $this->genders->removeElement($genders);
    }

    /**
     * Get genders
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGenders()
    {
        return $this->genders;
    }
}
