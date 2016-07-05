<?php

namespace Yalesov\Vcard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yalesov\Vcard\Entity\Anniversary
 */
class Anniversary
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
     * @var Yalesov\Vcard\Entity\DateTimeText
     */
    private $value;

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
     * Set param
     *
     * @param Yalesov\Vcard\Entity\Param $param
     * @return Anniversary
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
     * Set value
     *
     * @param Yalesov\Vcard\Entity\DateTimeText $value
     * @return Anniversary
     */
    public function setValue(\Yalesov\Vcard\Entity\DateTimeText $value = null)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return Yalesov\Vcard\Entity\DateTimeText 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set vcard
     *
     * @param Yalesov\Vcard\Entity\Vcard $vcard
     * @return Anniversary
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
