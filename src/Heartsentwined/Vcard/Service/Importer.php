<?php
namespace Heartsentwined\Vcard\Service;

use Heartsentwined\ArgValidator\ArgValidator;
use Heartsentwined\Utf8\Utf8;
use Heartsentwined\Vcard\Entity;
use Sabre\VObject\Node;
use Sabre\VObject\ParseException;
use Sabre\VObject\Reader;

class Importer
{
    /**
     * vcard source string
     *
     * @var string
     */
    protected $vcardStr;
    public function setVcardStr($vcardStr)
    {
        ArgValidator::assert($vcardStr, 'string');
        $this->vcardStr = $vcardStr;

        return $this;
    }
    public function getVcardStr()
    {
        return $this->vcardStr;
    }

    /**
     * vcard intermediate parser
     *
     * @var Reader
     */
    protected $reader;
    public function setReader(Reader $reader)
    {
        $this->reader = $reader;

        return $this;
    }
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * intermediate object, parsed from Reader
     *
     * @var Node
     */
    protected $card;
    public function setCard(Node $card)
    {
        $this->card = $card;

        return $this;
    }
    public function getCard()
    {
        return $this->card;
    }

    /**
     * Vcard entity
     *
     * @var Entity\Vcard
     */
    protected $vcard;

    /**
     * normalize vcard string for parsing
     *
     * @param  string $vcardStr
     * @return string
     */
    public function normalize($vcardStr)
    {
        ArgValidator::assert($vcardStr, 'string');

        if (strpos($vcardStr, 'BEGIN:') !== 0) {
            return '';
        }

        /* convert <U+xxxx> to characters */
        if (preg_match_all('/<[uU]\+([0-9A-Fa-f]{4})>/',
            $vcardStr, $matches, PREG_SET_ORDER)) {
            $conversions = array();
            foreach ($matches as $match) {
                $conversions[$match[0]] = Utf8::uchr(hexdec($match[1]));
            }
            $vcardStr = strtr($vcardStr, $conversions);
        }

        /* strip extra leading spaces */
        $vcardStr = preg_replace('/\n[\s]+/', "\n ", $vcardStr);

        return $vcardStr;
    }

    /**
     * parse vcard string into intermediate object
     *
     * @return Node|null
     */
    public function parse($vcardStr)
    {
        ArgValidator::assert($vcardStr, 'string');

        try {
            $card = $this->getReader()->read($vcardStr);
        } catch (ParseException $e) {
            return null;
        }

        return $card;
    }
}
