<?php

namespace Heartsentwined\Vcard\Entity;

/**
 * Heartsentwined\Vcard\Entity\Gender
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
     * @var Heartsentwined\Vcard\Entity\Param
     */
    private $param;

    /**
     * @var Heartsentwined\Vcard\Entity\Vcard
     */
    private $vcard;

    /**
     * @var Heartsentwined\Vcard\Entity\GenderValue
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
     * @param  string $comment
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
     * @param  Heartsentwined\Vcard\Entity\Param $param
     * @return Gender
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
     * Set vcard
     *
     * @param  Heartsentwined\Vcard\Entity\Vcard $vcard
     * @return Gender
     */
    public function setVcard(\Heartsentwined\Vcard\Entity\Vcard $vcard = null)
    {
        $this->vcard = $vcard;

        return $this;
    }

    /**
     * Get vcard
     *
     * @return Heartsentwined\Vcard\Entity\Vcard
     */
    public function getVcard()
    {
        return $this->vcard;
    }

    /**
     * Set value
     *
     * @param  Heartsentwined\Vcard\Entity\GenderValue $value
     * @return Gender
     */
    public function setValue(\Heartsentwined\Vcard\Entity\GenderValue $value = null)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return Heartsentwined\Vcard\Entity\GenderValue
     */
    public function getValue()
    {
        return $this->value;
    }
}
