<?php

namespace Yalesov\Vcard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yalesov\Vcard\Entity\KindValue
 */
class KindValue
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
  private $kinds;

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->kinds = new \Doctrine\Common\Collections\ArrayCollection();
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
   * @return KindValue
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
   * Add kinds
   *
   * @param Yalesov\Vcard\Entity\Kind $kinds
   * @return KindValue
   */
  public function addKind(\Yalesov\Vcard\Entity\Kind $kinds)
  {
    $this->kinds[] = $kinds;
  
    return $this;
  }

  /**
   * Remove kinds
   *
   * @param Yalesov\Vcard\Entity\Kind $kinds
   */
  public function removeKind(\Yalesov\Vcard\Entity\Kind $kinds)
  {
    $this->kinds->removeElement($kinds);
  }

  /**
   * Get kinds
   *
   * @return Doctrine\Common\Collections\Collection 
   */
  public function getKinds()
  {
    return $this->kinds;
  }
}
