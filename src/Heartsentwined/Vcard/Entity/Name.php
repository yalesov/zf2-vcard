<?php

namespace Heartsentwined\Vcard\Entity;

/**
 * Heartsentwined\Vcard\Entity\Name
 */
class Name
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
    private $familyNames;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $givenNames;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $additionalNames;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $prefixes;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $suffixes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->familyNames = new \Doctrine\Common\Collections\ArrayCollection();
        $this->givenNames = new \Doctrine\Common\Collections\ArrayCollection();
        $this->additionalNames = new \Doctrine\Common\Collections\ArrayCollection();
        $this->prefixes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->suffixes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Name
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
     * Add familyNames
     *
     * @param  Heartsentwined\Vcard\Entity\FamilyName $familyNames
     * @return Name
     */
    public function addFamilyName(\Heartsentwined\Vcard\Entity\FamilyName $familyNames)
    {
        $this->familyNames[] = $familyNames;

        return $this;
    }

    /**
     * Remove familyNames
     *
     * @param Heartsentwined\Vcard\Entity\FamilyName $familyNames
     */
    public function removeFamilyName(\Heartsentwined\Vcard\Entity\FamilyName $familyNames)
    {
        $this->familyNames->removeElement($familyNames);
    }

    /**
     * Get familyNames
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getFamilyNames()
    {
        return $this->familyNames;
    }

    /**
     * Add givenNames
     *
     * @param  Heartsentwined\Vcard\Entity\GivenName $givenNames
     * @return Name
     */
    public function addGivenName(\Heartsentwined\Vcard\Entity\GivenName $givenNames)
    {
        $this->givenNames[] = $givenNames;

        return $this;
    }

    /**
     * Remove givenNames
     *
     * @param Heartsentwined\Vcard\Entity\GivenName $givenNames
     */
    public function removeGivenName(\Heartsentwined\Vcard\Entity\GivenName $givenNames)
    {
        $this->givenNames->removeElement($givenNames);
    }

    /**
     * Get givenNames
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getGivenNames()
    {
        return $this->givenNames;
    }

    /**
     * Add additionalNames
     *
     * @param  Heartsentwined\Vcard\Entity\AdditionalName $additionalNames
     * @return Name
     */
    public function addAdditionalName(\Heartsentwined\Vcard\Entity\AdditionalName $additionalNames)
    {
        $this->additionalNames[] = $additionalNames;

        return $this;
    }

    /**
     * Remove additionalNames
     *
     * @param Heartsentwined\Vcard\Entity\AdditionalName $additionalNames
     */
    public function removeAdditionalName(\Heartsentwined\Vcard\Entity\AdditionalName $additionalNames)
    {
        $this->additionalNames->removeElement($additionalNames);
    }

    /**
     * Get additionalNames
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAdditionalNames()
    {
        return $this->additionalNames;
    }

    /**
     * Add prefixes
     *
     * @param  Heartsentwined\Vcard\Entity\Prefix $prefixes
     * @return Name
     */
    public function addPrefix(\Heartsentwined\Vcard\Entity\Prefix $prefixes)
    {
        $this->prefixes[] = $prefixes;

        return $this;
    }

    /**
     * Remove prefixes
     *
     * @param Heartsentwined\Vcard\Entity\Prefix $prefixes
     */
    public function removePrefix(\Heartsentwined\Vcard\Entity\Prefix $prefixes)
    {
        $this->prefixes->removeElement($prefixes);
    }

    /**
     * Get prefixes
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getPrefixes()
    {
        return $this->prefixes;
    }

    /**
     * Add suffixes
     *
     * @param  Heartsentwined\Vcard\Entity\Suffix $suffixes
     * @return Name
     */
    public function addSuffix(\Heartsentwined\Vcard\Entity\Suffix $suffixes)
    {
        $this->suffixes[] = $suffixes;

        return $this;
    }

    /**
     * Remove suffixes
     *
     * @param Heartsentwined\Vcard\Entity\Suffix $suffixes
     */
    public function removeSuffix(\Heartsentwined\Vcard\Entity\Suffix $suffixes)
    {
        $this->suffixes->removeElement($suffixes);
    }

    /**
     * Get suffixes
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSuffixes()
    {
        return $this->suffixes;
    }
}
