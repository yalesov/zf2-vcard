<?php
namespace Heartsentwined\Vcard\Service;

use Doctrine\ORM\EntityManager;
use Heartsentwined\ArgValidator\ArgValidator;
use Heartsentwined\Utf8\Utf8;
use Heartsentwined\Vcard\Entity;
use Heartsentwined\Vcard\Repository;
use Sabre\VObject\Node;
use Sabre\VObject\ParseException;
use Sabre\VObject\Property;
use Sabre\VObject\Reader;

class Importer
{
    /**
     * ORM Entity Manager
     *
     * @var EntityManager
     */
    protected $em;
    public function setEm(EntityManager $em)
    {
        $this->em = $em;

        return $this;
    }
    public function getEm()
    {
        return $this->em;
    }
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
    public function setVcard(Entity\Vcard $vcard)
    {
        $this->vcard = $vcard;

        return $this;
    }
    public function getVcard()
    {
        return $this->vcard;
    }

    /**
     * normalize vcard source for parsing
     *
     * @param  string $vcardStr
     * @return string
     */
    public function normalizeSource($vcardStr)
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
     * parse vcard source into intermediate object
     *
     * @return Node|null
     */
    public function parseSource($vcardStr)
    {
        ArgValidator::assert($vcardStr, 'string');

        try {
            $card = $this->getReader()->read($vcardStr);
        } catch (ParseException $e) {
            return null;
        }

        return $card;
    }

    /**
     * helper function to import common parameters
     *
     * @param  Property     $entitySrc
     * @return Entity\Param
     */
    public function importParam(Property $property)
    {
        static $paramMap = array(
            'ALTID'     => 'AltId',
            'GEO'       => 'Geo',
            'LABEL'     => 'Label',
            'LANGUAGE'  => 'Language',
            'MEDIATYPE' => 'MediaType',
            'PREF'      => 'Pref',
            'SORT-AS'   => 'SortAs',
            'TZ'        => 'Timezone',
        );

        static $typeRepo;
        static $typeMap = array();
        static $valueTypeRepo;
        static $valueTypeMap = array();

        // cannot use static, otherwise persist() won't work
        $em = $this->getEm();

        if (empty($typeRepo) || empty($valueTypeRepo)) {
            $typeRepo =
                $em->getRepository('Heartsentwined\Vcard\Entity\Type');
            $valueTypeRepo =
                $em->getRepository('Heartsentwined\Vcard\Entity\ParamValueType');
        }

        $param = new Entity\Param;
        $em->persist($param);

        foreach ($paramMap as $paramName => $propertyName) {
            $func = "set$propertyName";
            $param->$func((string) $property[$paramName]);
        }

        $value = (string) $property['VALUE'];
        if (!empty($value)) {
            if (isset($valueTypeMap[$value])) {
                $valueType = $valueTypeMap[$value];
            } elseif (!$valueType = $valueTypeRepo
                ->findOneBy(array('value' => $value))) {
                $valueType = new Entity\ParamValueType;
                $em->persist($valueType);
                $valueType->setValue($value);
                $valueTypeMap[$value] = $valueType;
            }
            $param->setValueType($valueType);
        }

        if (isset($property['TYPE']) && count($property['TYPE'])) {
            foreach ($property['TYPE'] as $eachType) {
                foreach (explode(',', $eachType) as $typeSrc) {
                    if ($typeSrc === '') continue;

                    if (isset($typeMap[$typeSrc])) {
                        $type = $typeMap[$typeSrc];
                    } elseif (!$type = $typeRepo
                        ->findOneBy(array('value' => $typeSrc))) {
                        $type = new Entity\Type;
                        $em->persist($type);
                        $type->setValue($typeSrc);
                        $typeMap[$typeSrc] = $type;
                    }
                    $param->addType($type);
                }
            }
        }

        return $param;
    }

    /**
     * multiple instances properties
     *
     * @param  Property   $property
     * @param  string     $entityClass
     * @return Entity\*[]
     */
    public function importMultiple(Property $property, $entityClass)
    {
        ArgValidator::assertClass($entityClass);

        $em = $this->getEm();
        $entities = array();
        foreach ($property as $eachProperty) {
            $entity = new $entityClass;
            $em->persist($entity);
            $entity
                ->setValue((string) $eachProperty)
                ->setParam($this->importParam($eachProperty));
            $entities[] = $entity;
        }

        return $entities;
    }

    /**
     * single instance properties
     *
     * @param  Property $property
     * @param  string   $entityClass
     * @return Entity\*
     */
    public function importSingle(Property $property, $entityClass)
    {
        ArgValidator::assertClass($entityClass);

        //get first instance
        foreach ($property as $property) { break; }

        $entity = new $entityClass;
        $this->getEm()->persist($entity);
        $entity
            ->setValue((string) $property)
            ->setParam($this->importParam($property));

        return $entity;
    }

    /**
     * SOURCE - Source
     *
     * @return self
     */
    public function importSource()
    {
        $vcard = $this->getVcard();
        if (($sourceSrc = $this->getCard()->SOURCE)
            && count($sourceSrc)) {
            foreach ($this->importMultiple($sourceSrc,
                'Heartsentwined\Vcard\Entity\Source')
            as $source) {
                $vcard->addSource($source);
            }
        }

        return $this;
    }

    /**
     * KIND - Kind
     *
     * @return self
     */
    public function importKind()
    {
        $em = $this->getEm();
        $card = $this->getCard();

        $kindValueSrc = (string) $card->KIND
            ? (string) $card->KIND : Repository\KindValue::DEF;
        if (!$kindValue = $em
            ->getRepository('Heartsentwined\Vcard\Entity\KindValue')
            ->findOneBy(array('value' => $kindValueSrc))) {
            $kindValue = new Entity\KindValue;
            $em->persist($kindValue);
            $kindValue->setValue($kindValueSrc);
        }
        $kind = new Entity\Kind;
        $em->persist($kind);
        $kind
            ->setValue($kindValue)
            ->setParam($this->importParam($card->KIND));
        $this->getVcard()->setKind($kind);

        return $this;
    }

    /**
     * FN - FormattedName
     *
     * @return self
     */
    public function importFormattedName()
    {
        $vcard = $this->getVcard();
        if (($formattedNameSrc = $this->getCard()->FN)
            && count($formattedNameSrc)) {
            foreach ($this->importMultiple($formattedNameSrc,
                'Heartsentwined\Vcard\Entity\FormattedName')
            as $formattedName) {
                $vcard->addFormattedName($formattedName);
            }
        }

        return $this;
    }

    /**
     * N - Name
     *
     * @return self
     */
    public function importName()
    {
        // not yet implemented
    }

    /**
     * NICKNAME - Nickname
     *
     * @return self
     */
    public function importNickname()
    {
        // not yet implemented
    }

    /**
     * PHOTO - Photo
     *
     * @return self
     */
    public function importPhoto()
    {
        $vcard = $this->getVcard();
        if (($photoSrc = $this->getCard()->PHOTO)
            && count($photoSrc)) {
            foreach ($this->importMultiple($photoSrc,
                'Heartsentwined\Vcard\Entity\Photo')
            as $photo) {
                $vcard->addPhoto($photo);
            }
        }

        return $this;
    }

    /**
     * BDAY - Birthday
     *
     * @return self
     */
    public function importBirthday()
    {
        // not yet implemented
    }

    /**
     * ANNIVERSARY - Anniversary
     *
     * @return self
     */
    public function importAnniversary()
    {
        // not yet implemented
    }

    /**
     * GENDER - Gender
     *
     * @return self
     */
    public function importGender()
    {
        $em = $this->getEm();
        $card = $this->getCard();
        $genderValueRepo =
            $em->getRepository('Heartsentwined\Vcard\Entity\GenderValue');

        $genderProperty = $card->GENDER;
        $genderValueSrc = (string) $card->GENDER;
        if ($genderValueSrc === '') {
            $genderProperty = $card->{'X-GENDER'};
            switch (strtolower($card->{'X-GENDER'})) { // non-standard form
                case 'male':
                case 'm':
                    $genderValueSrc = Repository\GenderValue::M;
                    break;
                case 'female':
                case 'f':
                    $genderValueSrc = Repository\GenderValue::F;
                    break;
            }
        }
        if ($genderValueSrc) {
            if (!strpos($genderValueSrc, ';')) {
                $genderValueSrc .= ';';
            }
            list($value, $comment) = explode(';', $genderValueSrc);
            $refl = new \ReflectionClass($genderValueRepo);
            if (!in_array($value, $refl->getConstants())) {
                $value = '';
            }
            $gender = new Entity\Gender;
            $em->persist($gender);
            $gender
                ->setComment($comment)
                ->setParam($this->importParam($genderProperty));
            if ($genderValue = $genderValueRepo
                ->findOneBy(array('value' => $value))) {
                $gender->setValue($genderValue);
            }
            $this->getVcard()->setGender($gender);
        }

        return $this;
    }

    /**
     * ADR - Address
     *
     * @return self
     */
    public function importAddress()
    {
        // not yet implemented
    }

    /**
     * TEL - Phone
     *
     * @return self
     */
    public function importPhone()
    {
        // not yet implemented
    }

    /**
     * EMAIL - Email
     *
     * @return self
     */
    public function importEmail()
    {
        $vcard = $this->getVcard();
        if (($emailSrc = $this->getCard()->EMAIL)
            && count($emailSrc)) {
            foreach ($this->importMultiple($emailSrc,
                'Heartsentwined\Vcard\Entity\Email')
            as $email) {
                $vcard->addEmail($email);
            }
        }

        return $this;
    }

    /**
     * IMPP / X-AIM / X-SKYPE / etc - Im
     *
     * @return self
     */
    public function importIm()
    {
        // not yet implemented
    }

    /**
     * LANG - Language
     *
     * @return self
     */
    public function importLanguage()
    {
        $vcard = $this->getVcard();
        if (($languageSrc = $this->getCard()->LANG)
            && count($languageSrc)) {
            foreach ($this->importMultiple($languageSrc,
                'Heartsentwined\Vcard\Entity\Language')
            as $language) {
                $vcard->addLanguage($language);
            }
        }

        return $this;
    }

    /**
     * TZ - Timezone
     *
     * @return self
     */
    public function importTimezone()
    {
        $vcard = $this->getVcard();
        if (($timezoneSrc = $this->getCard()->TZ)
            && count($timezoneSrc)) {
            foreach ($this->importMultiple($timezoneSrc,
                'Heartsentwined\Vcard\Entity\Timezone')
            as $timezone) {
                $vcard->addTimezone($timezone);
            }
        }

        return $this;
    }

    /**
     * GEO - Geo
     *
     * @return self
     */
    public function importGeo()
    {
        $vcard = $this->getVcard();
        if (($geoSrc = $this->getCard()->GEO)
            && count($geoSrc)) {
            foreach ($this->importMultiple($geoSrc,
                'Heartsentwined\Vcard\Entity\Geo')
            as $geo) {
                $vcard->addGeo($geo);
            }
        }

        return $this;
    }

    /**
     * TITLE - Title
     *
     * @return self
     */
    public function importTitle()
    {
        $vcard = $this->getVcard();
        if (($titleSrc = $this->getCard()->TITLE)
            && count($titleSrc)) {
            foreach ($this->importMultiple($titleSrc,
                'Heartsentwined\Vcard\Entity\Title')
            as $title) {
                $vcard->addTitle($title);
            }
        }

        return $this;
    }

    /**
     * ROLE - Role
     *
     * @return self
     */
    public function importRole()
    {
        $vcard = $this->getVcard();
        if (($roleSrc = $this->getCard()->ROLE)
            && count($roleSrc)) {
            foreach ($this->importMultiple($roleSrc,
                'Heartsentwined\Vcard\Entity\Role')
            as $role) {
                $vcard->addRole($role);
            }
        }

        return $this;
    }

    /**
     * LOGO - Logo
     *
     * @return self
     */
    public function importLogo()
    {
        $vcard = $this->getVcard();
        if (($logoSrc = $this->getCard()->LOGO)
            && count($logoSrc)) {
            foreach ($this->importMultiple($logoSrc,
                'Heartsentwined\Vcard\Entity\Logo')
            as $logo) {
                $vcard->addLogo($logo);
            }
        }

        return $this;
    }

    /**
     * ORG - Org
     *
     * @return self
     */
    public function importOrg()
    {
        $vcard = $this->getVcard();
        if (($orgSrc = $this->getCard()->ORG)
            && count($orgSrc)) {
            foreach ($this->importMultiple($orgSrc,
                'Heartsentwined\Vcard\Entity\Org')
            as $org) {
                $vcard->addOrg($org);
            }
        }

        return $this;
    }

    /**
     * MEMBER - Member
     *
     * @return self
     */
    public function importMember()
    {
        $vcard = $this->getVcard();
        if (($memberSrc = $this->getCard()->MEMBER)
            && count($memberSrc)) {
            foreach ($this->importMultiple($memberSrc,
                'Heartsentwined\Vcard\Entity\Member')
            as $member) {
                $vcard->addMember($member);
            }
        }

        return $this;
    }

    /**
     * RELATED - Relation
     *
     * @return self
     */
    public function importRelation()
    {
        // not yet implemented
    }

    /**
     * CATEGORIES - Tag
     *
     * @return self
     */
    public function importTag()
    {
        // not yet implemented
    }

    /**
     * NOTE - Note
     *
     * @return self
     */
    public function importNote()
    {
        $vcard = $this->getVcard();
        if (($noteSrc = $this->getCard()->NOTE)
            && count($noteSrc)) {
            foreach ($this->importMultiple($noteSrc,
                'Heartsentwined\Vcard\Entity\Note')
            as $note) {
                $vcard->addNote($note);
            }
        }

        return $this;
    }

    /**
     * SOUND - Sound
     *
     * @return self
     */
    public function importSound()
    {
        $vcard = $this->getVcard();
        if (($soundSrc = $this->getCard()->SOUND)
            && count($soundSrc)) {
            foreach ($this->importMultiple($soundSrc,
                'Heartsentwined\Vcard\Entity\Sound')
            as $sound) {
                $vcard->addSound($sound);
            }
        }

        return $this;
    }

    /**
     * UID - Uid
     *
     * @return self
     */
    public function importUid()
    {
        if (($uidSrc = $this->getCard()->UID)
            && count($uidSrc)) {
            $this->getVcard()->setUid($this->importSingle($uidSrc,
                'Heartsentwined\Vcard\Entity\Uid'));
        }

        return $this;
    }

    /**
     * URL - Url
     *
     * @return self
     */
    public function importUrl()
    {
        $vcard = $this->getVcard();
        if (($urlSrc = $this->getCard()->URL)
            && count($urlSrc)) {
            foreach ($this->importMultiple($urlSrc,
                'Heartsentwined\Vcard\Entity\Url')
            as $url) {
                $vcard->addUrl($url);
            }
        }

        return $this;
    }

    /**
     * KEY - PublicKey
     *
     * @return self
     */
    public function importPublicKey()
    {
        $vcard = $this->getVcard();
        if (($publicKeySrc = $this->getCard()->KEY)
            && count($publicKeySrc)) {
            foreach ($this->importMultiple($publicKeySrc,
                'Heartsentwined\Vcard\Entity\PublicKey')
            as $publicKey) {
                $vcard->addPublicKey($publicKey);
            }
        }

        return $this;
    }

    /**
     * FBURL - Freebusy
     *
     * @return self
     */
    public function importFreebusy()
    {
        $vcard = $this->getVcard();
        if (($freebusySrc = $this->getCard()->FBURL)
            && count($freebusySrc)) {
            foreach ($this->importMultiple($freebusySrc,
                'Heartsentwined\Vcard\Entity\Freebusy')
            as $freebusy) {
                $vcard->addFreebusy($freebusy);
            }
        }

        return $this;
    }

    /**
     * CALURI - Calendar
     *
     * @return self
     */
    public function importCalendar()
    {
        $vcard = $this->getVcard();
        if (($calendarSrc = $this->getCard()->CALURI)
            && count($calendarSrc)) {
            foreach ($this->importMultiple($calendarSrc,
                'Heartsentwined\Vcard\Entity\Calendar')
            as $calendar) {
                $vcard->addCalendar($calendar);
            }
        }

        return $this;
    }

    /**
     * CALADRURI - CalendarRequest
     *
     * @return self
     */
    public function importCalendarRequest()
    {
        $vcard = $this->getVcard();
        if (($calendarRequestSrc = $this->getCard()->CALADRURI)
            && count($calendarRequestSrc)) {
            foreach ($this->importMultiple($calendarRequestSrc,
                'Heartsentwined\Vcard\Entity\CalendarRequest')
            as $calendarRequest) {
                $vcard->addCalendarRequest($calendarRequest);
            }
        }

        return $this;
    }
}
