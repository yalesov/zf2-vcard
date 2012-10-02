<?php

namespace Heartsentwined\Vcard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Heartsentwined\Vcard\Entity\Relation
 */
class Relation
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
    private $relationTypes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->relationTypes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Relation
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
     * @return Relation
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
     * Add relationTypes
     *
     * @param Heartsentwined\Vcard\Entity\RelationType $relationTypes
     * @return Relation
     */
    public function addRelationType(\Heartsentwined\Vcard\Entity\RelationType $relationTypes)
    {
        $this->relationTypes[] = $relationTypes;
    
        return $this;
    }

    /**
     * Remove relationTypes
     *
     * @param Heartsentwined\Vcard\Entity\RelationType $relationTypes
     */
    public function removeRelationType(\Heartsentwined\Vcard\Entity\RelationType $relationTypes)
    {
        $this->relationTypes->removeElement($relationTypes);
    }

    /**
     * Get relationTypes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRelationTypes()
    {
        return $this->relationTypes;
    }
}
