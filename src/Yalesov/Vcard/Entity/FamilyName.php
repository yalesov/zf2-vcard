<?php

namespace Yalesov\Vcard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yalesov\Vcard\Entity\FamilyName
 */
class FamilyName
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
   * @return FamilyName
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
}
