<?php

namespace Yalesov\Vcard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yalesov\Vcard\Entity\DateTimeText
 */
class DateTimeText
{
  /**
   * @var integer $id
   */
  private $id;

  /**
   * @var string $format
   */
  private $format;

  /**
   * @var \DateTime $value
   */
  private $value;

  /**
   * @var integer $year
   */
  private $year;

  /**
   * @var integer $month
   */
  private $month;

  /**
   * @var integer $day
   */
  private $day;

  /**
   * @var integer $hour
   */
  private $hour;

  /**
   * @var integer $minute
   */
  private $minute;

  /**
   * @var integer $second
   */
  private $second;

  /**
   * @var string $timezone
   */
  private $timezone;

  /**
   * @var string $valueText
   */
  private $valueText;


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
   * Set format
   *
   * @param string $format
   * @return DateTimeText
   */
  public function setFormat($format)
  {
    $this->format = $format;
  
    return $this;
  }

  /**
   * Get format
   *
   * @return string 
   */
  public function getFormat()
  {
    return $this->format;
  }

  /**
   * Set value
   *
   * @param \DateTime $value
   * @return DateTimeText
   */
  public function setValue($value)
  {
    $this->value = $value;
  
    return $this;
  }

  /**
   * Get value
   *
   * @return \DateTime 
   */
  public function getValue()
  {
    return $this->value;
  }

  /**
   * Set year
   *
   * @param integer $year
   * @return DateTimeText
   */
  public function setYear($year)
  {
    $this->year = $year;
  
    return $this;
  }

  /**
   * Get year
   *
   * @return integer 
   */
  public function getYear()
  {
    return $this->year;
  }

  /**
   * Set month
   *
   * @param integer $month
   * @return DateTimeText
   */
  public function setMonth($month)
  {
    $this->month = $month;
  
    return $this;
  }

  /**
   * Get month
   *
   * @return integer 
   */
  public function getMonth()
  {
    return $this->month;
  }

  /**
   * Set day
   *
   * @param integer $day
   * @return DateTimeText
   */
  public function setDay($day)
  {
    $this->day = $day;
  
    return $this;
  }

  /**
   * Get day
   *
   * @return integer 
   */
  public function getDay()
  {
    return $this->day;
  }

  /**
   * Set hour
   *
   * @param integer $hour
   * @return DateTimeText
   */
  public function setHour($hour)
  {
    $this->hour = $hour;
  
    return $this;
  }

  /**
   * Get hour
   *
   * @return integer 
   */
  public function getHour()
  {
    return $this->hour;
  }

  /**
   * Set minute
   *
   * @param integer $minute
   * @return DateTimeText
   */
  public function setMinute($minute)
  {
    $this->minute = $minute;
  
    return $this;
  }

  /**
   * Get minute
   *
   * @return integer 
   */
  public function getMinute()
  {
    return $this->minute;
  }

  /**
   * Set second
   *
   * @param integer $second
   * @return DateTimeText
   */
  public function setSecond($second)
  {
    $this->second = $second;
  
    return $this;
  }

  /**
   * Get second
   *
   * @return integer 
   */
  public function getSecond()
  {
    return $this->second;
  }

  /**
   * Set timezone
   *
   * @param string $timezone
   * @return DateTimeText
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
   * Set valueText
   *
   * @param string $valueText
   * @return DateTimeText
   */
  public function setValueText($valueText)
  {
    $this->valueText = $valueText;
  
    return $this;
  }

  /**
   * Get valueText
   *
   * @return string 
   */
  public function getValueText()
  {
    return $this->valueText;
  }
}
