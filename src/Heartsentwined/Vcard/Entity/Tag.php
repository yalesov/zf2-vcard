<?php

namespace Heartsentwined\Vcard\Entity;

/**
 * Heartsentwined\Vcard\Entity\Tag
 */
class Tag
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
     * @param  Heartsentwined\Vcard\Entity\Param $param
     * @return Tag
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
     * Add values
     *
     * @param  Heartsentwined\Vcard\Entity\TagValue $values
     * @return Tag
     */
    public function addValue(\Heartsentwined\Vcard\Entity\TagValue $values)
    {
        $this->values[] = $values;

        return $this;
    }

    /**
     * Remove values
     *
     * @param Heartsentwined\Vcard\Entity\TagValue $values
     */
    public function removeValue(\Heartsentwined\Vcard\Entity\TagValue $values)
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
