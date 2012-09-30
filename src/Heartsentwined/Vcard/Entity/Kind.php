<?php

namespace Heartsentwined\Vcard\Entity;

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
     * @var Heartsentwined\Vcard\Entity\Param
     */
    private $param;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $vcards;

    /**
     * @var Heartsentwined\Vcard\Entity\KindValue
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
     * @param  Heartsentwined\Vcard\Entity\Param $param
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
     * @param  Heartsentwined\Vcard\Entity\Vcard $vcards
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

    /**
     * Set value
     *
     * @param  Heartsentwined\Vcard\Entity\KindValue $value
     * @return Kind
     */
    public function setValue(\Heartsentwined\Vcard\Entity\KindValue $value = null)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return Heartsentwined\Vcard\Entity\KindValue
     */
    public function getValue()
    {
        return $this->value;
    }
}
