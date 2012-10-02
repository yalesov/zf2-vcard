<?php

namespace Heartsentwined\Vcard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Heartsentwined\Vcard\Entity\Birthday
 */
class Birthday
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var Heartsentwined\Vcard\Entity\Param
     */
    private $param;

    /**
     * @var Heartsentwined\Vcard\Entity\DateTimeText
     */
    private $value;

    /**
     * @var Heartsentwined\Vcard\Entity\Vcard
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
     * Set param
     *
     * @param Heartsentwined\Vcard\Entity\Param $param
     * @return Birthday
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
     * Set value
     *
     * @param Heartsentwined\Vcard\Entity\DateTimeText $value
     * @return Birthday
     */
    public function setValue(\Heartsentwined\Vcard\Entity\DateTimeText $value = null)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return Heartsentwined\Vcard\Entity\DateTimeText 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set vcard
     *
     * @param Heartsentwined\Vcard\Entity\Vcard $vcard
     * @return Birthday
     */
    public function setVcard(\Heartsentwined\Vcard\Entity\Vcard $vcard = null)
    {
        $this->vcard = $vcard;
    
        return $this;
    }

    /**
     * Get vcard
     *
     * @return Heartsentwined\Vcard\Entity\Vcard 
     */
    public function getVcard()
    {
        return $this->vcard;
    }
}
