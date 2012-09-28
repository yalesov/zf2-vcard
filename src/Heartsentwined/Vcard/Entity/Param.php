<?php

namespace Heartsentwined\Vcard\Entity;

/**
 * Heartsentwined\Vcard\Entity\Param
 */
class Param
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $altId
     */
    private $altId;

    /**
     * @var string $geo
     */
    private $geo;

    /**
     * @var string $label
     */
    private $label;

    /**
     * @var string $language
     */
    private $language;

    /**
     * @var string $mediaType
     */
    private $mediaType;

    /**
     * @var integer $pref
     */
    private $pref;

    /**
     * @var string $sortAs
     */
    private $sortAs;

    /**
     * @var string $timezone
     */
    private $timezone;

    /**
     * @var Heartsentwined\Vcard\Entity\ParamValueType
     */
    private $valueType;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $types;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->types = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set altId
     *
     * @param  string $altId
     * @return Param
     */
    public function setAltId($altId)
    {
        $this->altId = $altId;

        return $this;
    }

    /**
     * Get altId
     *
     * @return string
     */
    public function getAltId()
    {
        return $this->altId;
    }

    /**
     * Set geo
     *
     * @param  string $geo
     * @return Param
     */
    public function setGeo($geo)
    {
        $this->geo = $geo;

        return $this;
    }

    /**
     * Get geo
     *
     * @return string
     */
    public function getGeo()
    {
        return $this->geo;
    }

    /**
     * Set label
     *
     * @param  string $label
     * @return Param
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set language
     *
     * @param  string $language
     * @return Param
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set mediaType
     *
     * @param  string $mediaType
     * @return Param
     */
    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    /**
     * Get mediaType
     *
     * @return string
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

    /**
     * Set pref
     *
     * @param  integer $pref
     * @return Param
     */
    public function setPref($pref)
    {
        $this->pref = $pref;

        return $this;
    }

    /**
     * Get pref
     *
     * @return integer
     */
    public function getPref()
    {
        return $this->pref;
    }

    /**
     * Set sortAs
     *
     * @param  string $sortAs
     * @return Param
     */
    public function setSortAs($sortAs)
    {
        $this->sortAs = $sortAs;

        return $this;
    }

    /**
     * Get sortAs
     *
     * @return string
     */
    public function getSortAs()
    {
        return $this->sortAs;
    }

    /**
     * Set timezone
     *
     * @param  string $timezone
     * @return Param
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set valueType
     *
     * @param  Heartsentwined\Vcard\Entity\ParamValueType $valueType
     * @return Param
     */
    public function setValueType(\Heartsentwined\Vcard\Entity\ParamValueType $valueType = null)
    {
        $this->valueType = $valueType;

        return $this;
    }

    /**
     * Get valueType
     *
     * @return Heartsentwined\Vcard\Entity\ParamValueType
     */
    public function getValueType()
    {
        return $this->valueType;
    }

    /**
     * Add types
     *
     * @param  Heartsentwined\Vcard\Entity\Type $types
     * @return Param
     */
    public function addType(\Heartsentwined\Vcard\Entity\Type $types)
    {
        $this->types[] = $types;

        return $this;
    }

    /**
     * Remove types
     *
     * @param Heartsentwined\Vcard\Entity\Type $types
     */
    public function removeType(\Heartsentwined\Vcard\Entity\Type $types)
    {
        $this->types->removeElement($types);
    }

    /**
     * Get types
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getTypes()
    {
        return $this->types;
    }
}
