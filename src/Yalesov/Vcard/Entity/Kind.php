<?php

namespace Yalesov\Vcard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yalesov\Vcard\Entity\Kind
 */
class Kind
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var Yalesov\Vcard\Entity\Param
     */
    private $param;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $vcards;

    /**
     * @var Yalesov\Vcard\Entity\KindValue
     */
    private $value;

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
     * Set param
     *
     * @param Yalesov\Vcard\Entity\Param $param
     * @return Kind
     */
    public function setParam(\Yalesov\Vcard\Entity\Param $param = null)
    {
        $this->param = $param;
    
        return $this;
    }

    /**
     * Get param
     *
     * @return Yalesov\Vcard\Entity\Param 
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * Add vcards
     *
     * @param Yalesov\Vcard\Entity\Vcard $vcards
     * @return Kind
     */
    public function addVcard(\Yalesov\Vcard\Entity\Vcard $vcards)
    {
        $this->vcards[] = $vcards;
    
        return $this;
    }

    /**
     * Remove vcards
     *
     * @param Yalesov\Vcard\Entity\Vcard $vcards
     */
    public function removeVcard(\Yalesov\Vcard\Entity\Vcard $vcards)
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

    /**
     * Set value
     *
     * @param Yalesov\Vcard\Entity\KindValue $value
     * @return Kind
     */
    public function setValue(\Yalesov\Vcard\Entity\KindValue $value = null)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return Yalesov\Vcard\Entity\KindValue 
     */
    public function getValue()
    {
        return $this->value;
    }
}
