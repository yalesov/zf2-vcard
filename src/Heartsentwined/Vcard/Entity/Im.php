<?php

namespace Heartsentwined\Vcard\Entity;

/**
 * Heartsentwined\Vcard\Entity\Im
 */
class Im
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
     * @var boolean $isUri
     */
    private $isUri;

    /**
     * @var Heartsentwined\Vcard\Entity\Param
     */
    private $param;

    /**
     * @var Heartsentwined\Vcard\Entity\ImProtocol
     */
    private $protocol;

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
     * @param  string $value
     * @return Im
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
     * Set isUri
     *
     * @param  boolean $isUri
     * @return Im
     */
    public function setIsUri($isUri)
    {
        $this->isUri = $isUri;

        return $this;
    }

    /**
     * Get isUri
     *
     * @return boolean
     */
    public function getIsUri()
    {
        return $this->isUri;
    }

    /**
     * Set param
     *
     * @param  Heartsentwined\Vcard\Entity\Param $param
     * @return Im
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
     * Set protocol
     *
     * @param  Heartsentwined\Vcard\Entity\ImProtocol $protocol
     * @return Im
     */
    public function setProtocol(\Heartsentwined\Vcard\Entity\ImProtocol $protocol = null)
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * Get protocol
     *
     * @return Heartsentwined\Vcard\Entity\ImProtocol
     */
    public function getProtocol()
    {
        return $this->protocol;
    }
}
