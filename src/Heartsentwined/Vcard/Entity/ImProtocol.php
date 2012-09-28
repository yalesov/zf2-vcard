<?php

namespace Heartsentwined\Vcard\Entity;

/**
 * Heartsentwined\Vcard\Entity\ImProtocol
 */
class ImProtocol
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
    private $ims;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ims = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param  string     $value
     * @return ImProtocol
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
     * Add ims
     *
     * @param  Heartsentwined\Vcard\Entity\Im $ims
     * @return ImProtocol
     */
    public function addIm(\Heartsentwined\Vcard\Entity\Im $ims)
    {
        $this->ims[] = $ims;

        return $this;
    }

    /**
     * Remove ims
     *
     * @param Heartsentwined\Vcard\Entity\Im $ims
     */
    public function removeIm(\Heartsentwined\Vcard\Entity\Im $ims)
    {
        $this->ims->removeElement($ims);
    }

    /**
     * Get ims
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getIms()
    {
        return $this->ims;
    }
}
