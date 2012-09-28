<?php

namespace Heartsentwined\Vcard\Entity;

/**
 * Heartsentwined\Vcard\Entity\Suffix
 */
class Suffix
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
     * @param  string $value
     * @return Suffix
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
