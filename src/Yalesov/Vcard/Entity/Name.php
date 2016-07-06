<?php

namespace Yalesov\Vcard\Entity;

/**
 * Yalesov\Vcard\Entity\Name
 */
class Name
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
   * @param  Yalesov\Vcard\Entity\Param $param
   * @return Name
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
   * Add familyNames
   *
   * @param  Yalesov\Vcard\Entity\FamilyName $familyNames
   * @return Name
   */
  public function addFamilyName(\Yalesov\Vcard\Entity\FamilyName $familyNames)
  {
    $this->familyNames[] = $familyNames;

    return $this;
  }

  /**
   * Remove familyNames
   *
   * @param Yalesov\Vcard\Entity\FamilyName $familyNames
   */
  public function removeFamilyName(\Yalesov\Vcard\Entity\FamilyName $familyNames)
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
   * @param  Yalesov\Vcard\Entity\GivenName $givenNames
   * @return Name
   */
  public function addGivenName(\Yalesov\Vcard\Entity\GivenName $givenNames)
  {
    $this->givenNames[] = $givenNames;

    return $this;
  }

  /**
   * Remove givenNames
   *
   * @param Yalesov\Vcard\Entity\GivenName $givenNames
   */
  public function removeGivenName(\Yalesov\Vcard\Entity\GivenName $givenNames)
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
   * @param  Yalesov\Vcard\Entity\AdditionalName $additionalNames
   * @return Name
   */
  public function addAdditionalName(\Yalesov\Vcard\Entity\AdditionalName $additionalNames)
  {
    $this->additionalNames[] = $additionalNames;

    return $this;
  }

  /**
   * Remove additionalNames
   *
   * @param Yalesov\Vcard\Entity\AdditionalName $additionalNames
   */
  public function removeAdditionalName(\Yalesov\Vcard\Entity\AdditionalName $additionalNames)
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
   * @param  Yalesov\Vcard\Entity\Prefix $prefixes
   * @return Name
   */
  public function addPrefix(\Yalesov\Vcard\Entity\Prefix $prefixes)
  {
    $this->prefixes[] = $prefixes;

    return $this;
  }

  /**
   * Remove prefixes
   *
   * @param Yalesov\Vcard\Entity\Prefix $prefixes
   */
  public function removePrefix(\Yalesov\Vcard\Entity\Prefix $prefixes)
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
   * @param  Yalesov\Vcard\Entity\Suffix $suffixes
   * @return Name
   */
  public function addSuffix(\Yalesov\Vcard\Entity\Suffix $suffixes)
  {
    $this->suffixes[] = $suffixes;

    return $this;
  }

  /**
   * Remove suffixes
   *
   * @param Yalesov\Vcard\Entity\Suffix $suffixes
   */
  public function removeSuffix(\Yalesov\Vcard\Entity\Suffix $suffixes)
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
