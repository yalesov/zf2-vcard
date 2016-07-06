<?php

namespace Yalesov\Vcard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yalesov\Vcard\Entity\Im
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
   * @var Yalesov\Vcard\Entity\Param
   */
  private $param;

  /**
   * @var Yalesov\Vcard\Entity\ImProtocol
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
   * @param string $value
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
   * @param boolean $isUri
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
   * @param Yalesov\Vcard\Entity\Param $param
   * @return Im
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
   * Set protocol
   *
   * @param Yalesov\Vcard\Entity\ImProtocol $protocol
   * @return Im
   */
  public function setProtocol(\Yalesov\Vcard\Entity\ImProtocol $protocol = null)
  {
    $this->protocol = $protocol;
  
    return $this;
  }

  /**
   * Get protocol
   *
   * @return Yalesov\Vcard\Entity\ImProtocol 
   */
  public function getProtocol()
  {
    return $this->protocol;
  }
}
