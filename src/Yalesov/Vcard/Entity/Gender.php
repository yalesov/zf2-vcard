<?php

namespace Yalesov\Vcard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yalesov\Vcard\Entity\Gender
 */
class Gender
{
  /**
   * @var integer $id
   */
  private $id;

  /**
   * @var string $comment
   */
  private $comment;

  /**
   * @var Yalesov\Vcard\Entity\Param
   */
  private $param;

  /**
   * @var Yalesov\Vcard\Entity\Vcard
   */
  private $vcard;

  /**
   * @var Yalesov\Vcard\Entity\GenderValue
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
   * Set comment
   *
   * @param string $comment
   * @return Gender
   */
  public function setComment($comment)
  {
    $this->comment = $comment;
  
    return $this;
  }

  /**
   * Get comment
   *
   * @return string 
   */
  public function getComment()
  {
    return $this->comment;
  }

  /**
   * Set param
   *
   * @param Yalesov\Vcard\Entity\Param $param
   * @return Gender
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
   * Set vcard
   *
   * @param Yalesov\Vcard\Entity\Vcard $vcard
   * @return Gender
   */
  public function setVcard(\Yalesov\Vcard\Entity\Vcard $vcard = null)
  {
    $this->vcard = $vcard;
  
    return $this;
  }

  /**
   * Get vcard
   *
   * @return Yalesov\Vcard\Entity\Vcard 
   */
  public function getVcard()
  {
    return $this->vcard;
  }

  /**
   * Set value
   *
   * @param Yalesov\Vcard\Entity\GenderValue $value
   * @return Gender
   */
  public function setValue(\Yalesov\Vcard\Entity\GenderValue $value = null)
  {
    $this->value = $value;
  
    return $this;
  }

  /**
   * Get value
   *
   * @return Yalesov\Vcard\Entity\GenderValue 
   */
  public function getValue()
  {
    return $this->value;
  }
}
