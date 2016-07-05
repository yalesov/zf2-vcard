<?php

namespace Yalesov\Vcard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yalesov\Vcard\Entity\Uid
 */
class Uid
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
     * @var Yalesov\Vcard\Entity\Param
     */
    private $param;

    /**
     * @var Yalesov\Vcard\Entity\Vcard
     */
    private $vcard;


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
     * @return Uid
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
     * @param Yalesov\Vcard\Entity\Param $param
     * @return Uid
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
     * Set vcard
     *
     * @param Yalesov\Vcard\Entity\Vcard $vcard
     * @return Uid
     */
    public function setVcard(\Yalesov\Vcard\Entity\Vcard $vcard = null)
    {
        $this->vcard = $vcard;
    
        return $this;
    }

    /**
     * Get vcard
     *
     * @return Yalesov\Vcard\Entity\Vcard 
     */
    public function getVcard()
    {
        return $this->vcard;
    }
}
