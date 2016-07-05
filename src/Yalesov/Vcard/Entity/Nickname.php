<?php

namespace Yalesov\Vcard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yalesov\Vcard\Entity\Nickname
 */
class Nickname
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
    private $values;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->values = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Nickname
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
     * Add values
     *
     * @param Yalesov\Vcard\Entity\NicknameValue $values
     * @return Nickname
     */
    public function addValue(\Yalesov\Vcard\Entity\NicknameValue $values)
    {
        $this->values[] = $values;
    
        return $this;
    }

    /**
     * Remove values
     *
     * @param Yalesov\Vcard\Entity\NicknameValue $values
     */
    public function removeValue(\Yalesov\Vcard\Entity\NicknameValue $values)
    {
        $this->values->removeElement($values);
    }

    /**
     * Get values
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getValues()
    {
        return $this->values;
    }
}
