<?php

namespace Yalesov\Vcard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yalesov\Vcard\Entity\ParamValueType
 */
class ParamValueType
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
    private $params;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->params = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return ParamValueType
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
     * Add params
     *
     * @param Yalesov\Vcard\Entity\Param $params
     * @return ParamValueType
     */
    public function addParam(\Yalesov\Vcard\Entity\Param $params)
    {
        $this->params[] = $params;
    
        return $this;
    }

    /**
     * Remove params
     *
     * @param Yalesov\Vcard\Entity\Param $params
     */
    public function removeParam(\Yalesov\Vcard\Entity\Param $params)
    {
        $this->params->removeElement($params);
    }

    /**
     * Get params
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getParams()
    {
        return $this->params;
    }
}
