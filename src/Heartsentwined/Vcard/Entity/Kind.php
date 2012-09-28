<?php

namespace Heartsentwined\Vcard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Heartsentwined\Vcard\Entity\Kind
 */
class Kind
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
     * @var Heartsentwined\Vcard\Entity\Param
     */
    private $param;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $vcards;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vcards = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Kind
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
     * Set param
     *
     * @param Heartsentwined\Vcard\Entity\Param $param
     * @return Kind
     */
    public function setParam(\Heartsentwined\Vcard\Entity\Param $param = null)
    {
        $this->param = $param;
    
        return $this;
    }

    /**
     * Get param
     *
     * @return Heartsentwined\Vcard\Entity\Param 
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * Add vcards
     *
     * @param Heartsentwined\Vcard\Entity\Vcard $vcards
     * @return Kind
     */
    public function addVcard(\Heartsentwined\Vcard\Entity\Vcard $vcards)
    {
        $this->vcards[] = $vcards;
    
        return $this;
    }

    /**
     * Remove vcards
     *
     * @param Heartsentwined\Vcard\Entity\Vcard $vcards
     */
    public function removeVcard(\Heartsentwined\Vcard\Entity\Vcard $vcards)
    {
        $this->vcards->removeElement($vcards);
    }

    /**
     * Get vcards
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVcards()
    {
        return $this->vcards;
    }
}
