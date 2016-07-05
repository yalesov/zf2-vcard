<?php
namespace Yalesov\Vcard\Test\Service;

use Yalesov\DateTimeParser\Parser as DateTimeParser;
use Yalesov\Vcard\Entity;
use Yalesov\Vcard\Repository;
use Yalesov\Vcard\Service\Importer;
use Yalesov\Phpunit\Testcase\Doctrine as DoctrineTestcase;

class ImporterTest extends DoctrineTestcase
{
    public function setUp()
    {
        $this
            ->setBootstrap(__DIR__ . '/../../../../../bootstrap.php')
            ->setEmAlias('doctrine.entitymanager.orm_default')
            ->setTmpDir('tmp');
        parent::setUp();

        $this->importer = $this->sm->get('vcard-importer')
            ->setEm($this->em)
            ->setReader($this->sm->get('Sabre\VObject\Reader'))
            ->setDateTimeParser(
                $this->sm->get('Yalesov\DateTimeParser\Parser'));
    }

    public function tearDown()
    {
        $this->importer = null;
        parent::tearDown();
    }

    public function testNormalizeSource()
    {
        $this->assertSame('', $this->importer->normalizeSource(''));
        $this->assertSame("BEGIN:\né",
            $this->importer->normalizeSource("BEGIN:\n<u+00e9>"));
        $this->assertSame(<<<STR
BEGIN:VCARD
 foo
STR
            , $this->importer->normalizeSource(<<<STR
BEGIN:VCARD
        foo
STR
        ));
    }

    public function testParseSource()
    {
        $this->assertInstanceOf(
            'Sabre\VObject\Node',
            $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
            ));
    }

    /**
     * @depends testParseSource
     */
    public function testImportParam()
    {
        $oldValue = new Entity\ParamValueType;
        $this->em->persist($oldValue);
        $oldValue->setValue('old-value');

        $work = new Entity\Type;
        $this->em->persist($work);
        $work->setValue('work');

        $home = new Entity\Type;
        $this->em->persist($home);
        $home->setValue('home');

        $this->em->flush();

        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
ALL;ALTID=altid;GEO=geo;LABEL=label;LANGUAGE=language;MEDIATYPE=mediatype;
 PREF=pref;SORT-AS=sort-as;TZ=tz:foo
ALLEMPTY;ALTID=;GEO=;LABEL=;LANGUAGE=;MEDIATYPE=;
 PREF=;SORT-AS=;TZ=:foo
VALUE-OLD;VALUE=old-value:foo
VALUE-NEW;VALUE=new-value:foo
VALUE-EMPTY;VALUE=:foo
TYPE-COMMA;TYPE=work,home:foo
TYPE-NEW;TYPE=new-type:foo
TYPE-EMPTY;TYPE=:foo
END:VCARD
STR
        );

        $param = $this->importer->importParam($card->ALL);
        $this->assertSame('altid', $param->getAltId());
        $this->assertSame('geo', $param->getGeo());
        $this->assertSame('label', $param->getLabel());
        $this->assertSame('language', $param->getLanguage());
        $this->assertSame('mediatype', $param->getMediaType());
        $this->assertSame('pref', $param->getPref());
        $this->assertSame('sort-as', $param->getSortAs());
        $this->assertSame('tz', $param->getTimezone());
        $this->assertEmpty($param->getValueType());
        $this->assertCount(0, $param->getTypes());

        $param = $this->importer->importParam($card->ALLEMPTY);
        $this->assertSame('', $param->getAltId());
        $this->assertSame('', $param->getGeo());
        $this->assertSame('', $param->getLabel());
        $this->assertSame('', $param->getLanguage());
        $this->assertSame('', $param->getMediaType());
        $this->assertSame('', $param->getPref());
        $this->assertSame('', $param->getSortAs());
        $this->assertSame('', $param->getTimezone());
        $this->assertEmpty($param->getValueType());
        $this->assertCount(0, $param->getTypes());

        $param = $this->importer->importParam($card->{'VALUE-OLD'});
        $this->assertSame('', $param->getAltId());
        $this->assertSame('', $param->getGeo());
        $this->assertSame('', $param->getLabel());
        $this->assertSame('', $param->getLanguage());
        $this->assertSame('', $param->getMediaType());
        $this->assertSame('', $param->getPref());
        $this->assertSame('', $param->getSortAs());
        $this->assertSame('', $param->getTimezone());
        $this->assertSame($oldValue, $param->getValueType());
        $this->assertCount(0, $param->getTypes());

        $param = $this->importer->importParam($card->{'VALUE-NEW'});
        $this->assertSame('', $param->getAltId());
        $this->assertSame('', $param->getGeo());
        $this->assertSame('', $param->getLabel());
        $this->assertSame('', $param->getLanguage());
        $this->assertSame('', $param->getMediaType());
        $this->assertSame('', $param->getPref());
        $this->assertSame('', $param->getSortAs());
        $this->assertSame('', $param->getTimezone());
        $newValue = $param->getValueType();
        $this->assertNotEmpty($newValue);
        $this->assertSame('new-value', $newValue->getValue());
        $this->assertCount(0, $param->getTypes());

        $param = $this->importer->importParam($card->{'VALUE-EMPTY'});
        $this->assertSame('', $param->getAltId());
        $this->assertSame('', $param->getGeo());
        $this->assertSame('', $param->getLabel());
        $this->assertSame('', $param->getLanguage());
        $this->assertSame('', $param->getMediaType());
        $this->assertSame('', $param->getPref());
        $this->assertSame('', $param->getSortAs());
        $this->assertSame('', $param->getTimezone());
        $this->assertEmpty($param->getValueType());
        $this->assertCount(0, $param->getTypes());

        $param = $this->importer->importParam($card->{'TYPE-COMMA'});
        $this->assertSame('', $param->getAltId());
        $this->assertSame('', $param->getGeo());
        $this->assertSame('', $param->getLabel());
        $this->assertSame('', $param->getLanguage());
        $this->assertSame('', $param->getMediaType());
        $this->assertSame('', $param->getPref());
        $this->assertSame('', $param->getSortAs());
        $this->assertSame('', $param->getTimezone());
        $this->assertEmpty($param->getValueType());
        $types = $param->getTypes();
        $this->assertCount(2, $types);
        $actual = array();
        foreach ($types as $type) {
            $actual[] = $type;
        }
        $this->assertSame(array($work, $home), $actual);

        $param = $this->importer->importParam($card->{'TYPE-NEW'});
        $this->assertSame('', $param->getAltId());
        $this->assertSame('', $param->getGeo());
        $this->assertSame('', $param->getLabel());
        $this->assertSame('', $param->getLanguage());
        $this->assertSame('', $param->getMediaType());
        $this->assertSame('', $param->getPref());
        $this->assertSame('', $param->getSortAs());
        $this->assertSame('', $param->getTimezone());
        $this->assertEmpty($param->getValueType());
        $types = $param->getTypes();
        $this->assertCount(1, $types);
        $newType = $types[0];
        $this->assertSame('new-type', $newType->getValue());

        $param = $this->importer->importParam($card->{'TYPE-EMPTY'});
        $this->assertSame('', $param->getAltId());
        $this->assertSame('', $param->getGeo());
        $this->assertSame('', $param->getLabel());
        $this->assertSame('', $param->getLanguage());
        $this->assertSame('', $param->getMediaType());
        $this->assertSame('', $param->getPref());
        $this->assertSame('', $param->getSortAs());
        $this->assertSame('', $param->getTimezone());
        $this->assertEmpty($param->getValueType());
        $this->assertCount(0, $param->getTypes());
    }

    /**
     * @depends testParseSource
     */
    public function testImportMultiple()
    {
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
ORG;LANGUAGE=foo:foo
ORG;LANGUAGE=bar:bar
END:VCARD
STR
        );

        $orgs = $this->importer->importMultiple(
            $card->ORG, 'Yalesov\Vcard\Entity\Org');
        $this->em->flush();
        $this->assertCount(2, $orgs);
        $this->assertCount(2, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Org')->findAll());

        $foo = $orgs[0];
        $bar = $orgs[1];

        $this->assertSame('foo', $foo->getValue());
        $this->assertSame('bar', $bar->getValue());
    }

    /**
     * @depends testParseSource
     */
    public function testImportMultipleWithType()
    {
        // simple entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
TEL;TYPE=foo:123
TEL;TYPE=bar:456
END:VCARD
STR
        );

        $phones = $this->importer->importMultipleWithType(
            $card->TEL, 'Yalesov\Vcard\Entity\Phone');
        $this->em->flush();
        $this->assertCount(2, $phones);
        $this->assertCount(2, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Phone')->findAll());
        $this->assertCount(2, $this->em
            ->getRepository('Yalesov\Vcard\Entity\PhoneType')
            ->findAll());

        $this->assertSame('123', $phones[0]->getValue());
        $types = $phones[0]->getPhoneTypes();
        $this->assertCount(1, $types);
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\PhoneType', $types[0]);
        $this->assertSame('foo', $types[0]->getValue());

        $this->assertSame('456', $phones[1]->getValue());
        $types = $phones[1]->getPhoneTypes();
        $this->assertCount(1, $types);
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\PhoneType', $types[0]);
        $this->assertSame('bar', $types[0]->getValue());

        // different type syntaxes
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
TEL;TYPE=foo;TYPE=bar;TYPE=baz,qux:123
END:VCARD
STR
        );

        $phones = $this->importer->importMultipleWithType(
            $card->TEL, 'Yalesov\Vcard\Entity\Phone');
        $this->em->flush();
        $this->assertCount(1, $phones);
        $this->assertCount(3, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Phone')->findAll());
        $this->assertCount(4, $this->em
            ->getRepository('Yalesov\Vcard\Entity\PhoneType')
            ->findAll());

        $this->assertSame('123', $phones[0]->getValue());
        $types = $phones[0]->getPhoneTypes();
        $this->assertCount(4, $types);
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\PhoneType', $types[0]);
        $this->assertSame('foo', $types[0]->getValue());
        $this->assertSame('bar', $types[1]->getValue());
        $this->assertSame('baz', $types[2]->getValue());
        $this->assertSame('qux', $types[3]->getValue());
    }

    /**
     * @depends testParseSource
     */
    public function testImportSingleDateTime()
    {
        // full date
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
BDAY:19900101T010101Z
BDAY:19900101T010101Z
END:VCARD
STR
        );

        $birthday = $this->importer->importSingleDatetime(
            $card->BDAY, 'Yalesov\Vcard\Entity\Birthday');
        $this->em->flush();
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Birthday')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\DateTimeText')
            ->findAll());

        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Birthday', $birthday);
        $dateTimeText = $birthday->getValue();
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\DateTimeText', $dateTimeText);
        $this->assertSame(
            Repository\DateTimeText::FULL, $dateTimeText->getFormat());
        $this->assertSame(
            DateTimeParser::createTimestamp(
                '1990', '01', '01', '01', '01', '01', '+0000'),
            $dateTimeText->getValue()->getTimestamp());
        $this->assertSame('1990', $dateTimeText->getYear());
        $this->assertSame('01', $dateTimeText->getMonth());
        $this->assertSame('01', $dateTimeText->getDay());
        $this->assertSame('01', $dateTimeText->getHour());
        $this->assertSame('01', $dateTimeText->getMinute());
        $this->assertSame('01', $dateTimeText->getSecond());
        $this->assertSame('+0000', $dateTimeText->getTimezone());
        $this->assertEmpty($dateTimeText->getValueText());

        // partial date
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
BDAY:--0101
BDAY:--0101
END:VCARD
STR
        );

        $birthday = $this->importer->importSingleDatetime(
            $card->BDAY, 'Yalesov\Vcard\Entity\Birthday');
        $this->em->flush();
        $this->assertCount(2, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Birthday')
            ->findAll());
        $this->assertCount(2, $this->em
            ->getRepository('Yalesov\Vcard\Entity\DateTimeText')
            ->findAll());

        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Birthday', $birthday);
        $dateTimeText = $birthday->getValue();
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\DateTimeText', $dateTimeText);
        $this->assertSame(
            Repository\DateTimeText::PARTIAL, $dateTimeText->getFormat());
        $this->assertEmpty($dateTimeText->getValue());
        $this->assertEmpty($dateTimeText->getYear());
        $this->assertSame('01', $dateTimeText->getMonth());
        $this->assertSame('01', $dateTimeText->getDay());
        $this->assertEmpty($dateTimeText->getHour());
        $this->assertEmpty($dateTimeText->getMinute());
        $this->assertEmpty($dateTimeText->getSecond());
        $this->assertEmpty($dateTimeText->getTimezone());
        $this->assertEmpty($dateTimeText->getValueText());

        // text
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
BDAY;VALUE=text:foo
BDAY;VALUE=text:foo
END:VCARD
STR
        );

        $birthday = $this->importer->importSingleDatetime(
            $card->BDAY, 'Yalesov\Vcard\Entity\Birthday');
        $this->em->flush();
        $this->assertCount(3, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Birthday')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Yalesov\Vcard\Entity\DateTimeText')
            ->findAll());

        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Birthday', $birthday);
        $dateTimeText = $birthday->getValue();
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\DateTimeText', $dateTimeText);
        $this->assertSame(
            Repository\DateTimeText::TEXT, $dateTimeText->getFormat());
        $this->assertEmpty($dateTimeText->getValue());
        $this->assertEmpty($dateTimeText->getYear());
        $this->assertEmpty($dateTimeText->getMonth());
        $this->assertEmpty($dateTimeText->getDay());
        $this->assertEmpty($dateTimeText->getHour());
        $this->assertEmpty($dateTimeText->getMinute());
        $this->assertEmpty($dateTimeText->getSecond());
        $this->assertEmpty($dateTimeText->getTimezone());
        $this->assertSame('foo', $dateTimeText->getValueText());
    }

    /**
     * @depends testParseSource
     */
    public function testImportSingle()
    {
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
ORG;LANGUAGE=foo:foo
ORG;LANGUAGE=bar:bar
END:VCARD
STR
        );

        $foo = $this->importer->importSingle(
            $card->ORG, 'Yalesov\Vcard\Entity\Org');
        $this->em->flush();
        $this->assertInstanceOf('Yalesov\Vcard\Entity\Org', $foo);
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Org')->findAll());

        $this->assertSame('foo', $foo->getValue());
    }

    /**
     * @depends testParseSource
     */
    public function testImportSource()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
SOURCE:foo
SOURCE:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addSource'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addSource');

        $this->importer->importSource();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
SOURCE:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addSource'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addSource');

        $this->importer->importSource();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addSource'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addSource');

        $this->importer->importSource();
    }

    /**
     * @depends testParseSource
     */
    public function testImportKind()
    {
        $default = Repository\KindValue::DEF;
        $defaultValue = new Entity\KindValue;
        $this->em->persist($defaultValue);
        $defaultValue->setValue($default);
        $this->em->flush();

        // default value
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
KIND:$default
END:VCARD
STR
        );

        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importKind();
        $this->em->flush();
        $kind = $vcard->getKind();
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Kind', $kind);
        $this->assertSame($defaultValue, $kind->getValue());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\KindValue')
            ->findAll());

        // empty: assume default
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
KIND:
END:VCARD
STR
        );

        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importKind();
        $this->em->flush();
        $kind = $vcard->getKind();
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Kind', $kind);
        $this->assertSame($defaultValue, $kind->getValue());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\KindValue')
            ->findAll());

        // new kind
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
KIND:foo
END:VCARD
STR
        );

        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importKind();
        $this->em->flush();
        $kind = $vcard->getKind();
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Kind', $kind);
        $kindValue = $kind->getValue();
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\KindValue', $kindValue);
        $this->assertSame('foo', $kindValue->getValue());
        $this->assertCount(2, $this->em
            ->getRepository('Yalesov\Vcard\Entity\KindValue')
            ->findAll());

        // no kind: assume default
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importKind();
        $this->em->flush();
        $kind = $vcard->getKind();
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Kind', $kind);
        $this->assertSame($defaultValue, $kind->getValue());
        $this->assertCount(2, $this->em
            ->getRepository('Yalesov\Vcard\Entity\KindValue')
            ->findAll());
    }

    /**
     * @depends testParseSource
     */
    public function testImportFormattedName()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FN:foo
FN:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addFormattedName'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addFormattedName');

        $this->importer->importFormattedName();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FN:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addFormattedName'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addFormattedName');

        $this->importer->importFormattedName();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addFormattedName'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addFormattedName');

        $this->importer->importFormattedName();
    }

    /**
     * @depends testParseSource
     */
    public function testImportName()
    {
        // standard entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
N:family;given;additional;prefix;suffix
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importName();
        $this->em->flush();
        $names = $vcard->getNames();
        $this->assertCount(1, $names);
        foreach ($names as $name) {
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Name', $name);
            $familyNames = $name->getFamilyNames();
            $this->assertCount(1, $familyNames);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\FamilyName', $familyNames[0]);
            $this->assertSame('family', $familyNames[0]->getValue());

            $givenNames = $name->getGivenNames();
            $this->assertCount(1, $givenNames);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\GivenName', $givenNames[0]);
            $this->assertSame('given', $givenNames[0]->getValue());

            $additionalNames = $name->getAdditionalNames();
            $this->assertCount(1, $additionalNames);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\AdditionalName',
                $additionalNames[0]);
            $this->assertSame('additional', $additionalNames[0]->getValue());

            $prefixes = $name->getPrefixes();
            $this->assertCount(1, $prefixes);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Prefix', $prefixes[0]);
            $this->assertSame('prefix', $prefixes[0]->getValue());

            $suffixes = $name->getSuffixes();
            $this->assertCount(1, $suffixes);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Suffix', $suffixes[0]);
            $this->assertSame('suffix', $suffixes[0]->getValue());
        }
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Name')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\FamilyName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GivenName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\AdditionalName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Prefix')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Suffix')
            ->findAll());

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
N:
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importName();
        $this->em->flush();
        $names = $vcard->getNames();
        $this->assertCount(0, $names);
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Name')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\FamilyName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GivenName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\AdditionalName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Prefix')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Suffix')
            ->findAll());

        // empty components
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
N:;;;;
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importName();
        $this->em->flush();
        $names = $vcard->getNames();
        $this->assertCount(1, $names);
        foreach ($names as $name) {
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Name', $name);
            $familyNames = $name->getFamilyNames();
            $this->assertCount(0, $familyNames);

            $givenNames = $name->getGivenNames();
            $this->assertCount(0, $givenNames);

            $additionalNames = $name->getAdditionalNames();
            $this->assertCount(0, $additionalNames);

            $prefixes = $name->getPrefixes();
            $this->assertCount(0, $prefixes);

            $suffixes = $name->getSuffixes();
            $this->assertCount(0, $suffixes);
        }
        $this->assertCount(2, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Name')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\FamilyName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GivenName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\AdditionalName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Prefix')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Suffix')
            ->findAll());

        // multiple components
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
N:family1,family2;given1,given2;add1,add2;prefix1,prefix2;suffix1,suffix2
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importName();
        $this->em->flush();
        $names = $vcard->getNames();
        $this->assertCount(1, $names);
        foreach ($names as $name) {
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Name', $name);
            $familyNames = $name->getFamilyNames();
            $this->assertCount(2, $familyNames);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\FamilyName', $familyNames[0]);
            $this->assertSame('family1', $familyNames[0]->getValue());
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\FamilyName', $familyNames[1]);
            $this->assertSame('family2', $familyNames[1]->getValue());

            $givenNames = $name->getGivenNames();
            $this->assertCount(2, $givenNames);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\GivenName', $givenNames[0]);
            $this->assertSame('given1', $givenNames[0]->getValue());
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\GivenName', $givenNames[1]);
            $this->assertSame('given2', $givenNames[1]->getValue());

            $additionalNames = $name->getAdditionalNames();
            $this->assertCount(2, $additionalNames);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\AdditionalName',
                $additionalNames[0]);
            $this->assertSame('add1', $additionalNames[0]->getValue());
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\AdditionalName',
                $additionalNames[1]);
            $this->assertSame('add2', $additionalNames[1]->getValue());

            $prefixes = $name->getPrefixes();
            $this->assertCount(2, $prefixes);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Prefix', $prefixes[0]);
            $this->assertSame('prefix1', $prefixes[0]->getValue());
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Prefix', $prefixes[1]);
            $this->assertSame('prefix2', $prefixes[1]->getValue());

            $suffixes = $name->getSuffixes();
            $this->assertCount(2, $suffixes);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Suffix', $suffixes[0]);
            $this->assertSame('suffix1', $suffixes[0]->getValue());
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Suffix', $suffixes[1]);
            $this->assertSame('suffix2', $suffixes[1]->getValue());
        }
        $this->assertCount(3, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Name')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Yalesov\Vcard\Entity\FamilyName')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GivenName')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Yalesov\Vcard\Entity\AdditionalName')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Prefix')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Suffix')
            ->findAll());

        // missing components
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
N:family;given
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importName();
        $this->em->flush();
        $names = $vcard->getNames();
        $this->assertCount(1, $names);
        foreach ($names as $name) {
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Name', $name);
            $familyNames = $name->getFamilyNames();
            $this->assertCount(1, $familyNames);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\FamilyName', $familyNames[0]);
            $this->assertSame('family', $familyNames[0]->getValue());

            $givenNames = $name->getGivenNames();
            $this->assertCount(1, $givenNames);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\GivenName', $givenNames[0]);
            $this->assertSame('given', $givenNames[0]->getValue());

            $additionalNames = $name->getAdditionalNames();
            $this->assertCount(0, $additionalNames);

            $prefixes = $name->getPrefixes();
            $this->assertCount(0, $prefixes);

            $suffixes = $name->getSuffixes();
            $this->assertCount(0, $suffixes);
        }
        $this->assertCount(4, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Name')
            ->findAll());
        $this->assertCount(4, $this->em
            ->getRepository('Yalesov\Vcard\Entity\FamilyName')
            ->findAll());
        $this->assertCount(4, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GivenName')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Yalesov\Vcard\Entity\AdditionalName')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Prefix')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Suffix')
            ->findAll());

        // multiple entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
N:family;given;additional;prefix;suffix
N:family;given;additional;prefix;suffix
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importName();
        $this->em->flush();
        $names = $vcard->getNames();
        $this->assertCount(2, $names);
        foreach ($names as $name) {
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Name', $name);
            $familyNames = $name->getFamilyNames();
            $this->assertCount(1, $familyNames);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\FamilyName', $familyNames[0]);
            $this->assertSame('family', $familyNames[0]->getValue());

            $givenNames = $name->getGivenNames();
            $this->assertCount(1, $givenNames);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\GivenName', $givenNames[0]);
            $this->assertSame('given', $givenNames[0]->getValue());

            $additionalNames = $name->getAdditionalNames();
            $this->assertCount(1, $additionalNames);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\AdditionalName',
                $additionalNames[0]);
            $this->assertSame('additional', $additionalNames[0]->getValue());

            $prefixes = $name->getPrefixes();
            $this->assertCount(1, $prefixes);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Prefix', $prefixes[0]);
            $this->assertSame('prefix', $prefixes[0]->getValue());

            $suffixes = $name->getSuffixes();
            $this->assertCount(1, $suffixes);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Suffix', $suffixes[0]);
            $this->assertSame('suffix', $suffixes[0]->getValue());
        }
        $this->assertCount(6, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Name')
            ->findAll());
        $this->assertCount(6, $this->em
            ->getRepository('Yalesov\Vcard\Entity\FamilyName')
            ->findAll());
        $this->assertCount(6, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GivenName')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Yalesov\Vcard\Entity\AdditionalName')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Prefix')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Suffix')
            ->findAll());

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importName();
        $this->em->flush();
        $names = $vcard->getNames();
        $this->assertCount(0, $names);
        $this->assertCount(6, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Name')
            ->findAll());
        $this->assertCount(6, $this->em
            ->getRepository('Yalesov\Vcard\Entity\FamilyName')
            ->findAll());
        $this->assertCount(6, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GivenName')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Yalesov\Vcard\Entity\AdditionalName')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Prefix')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Suffix')
            ->findAll());
    }

    /**
     * @depends testParseSource
     */
    public function testImportNickname()
    {
        // standard entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
NICKNAME:foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importNickname();
        $this->em->flush();
        $nicknames = $vcard->getNicknames();
        $this->assertCount(1, $nicknames);
        foreach ($nicknames as $nickname) {
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Nickname', $nickname);
            $values = $nickname->getValues();
            $this->assertCount(1, $values);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\NicknameValue', $values[0]);
            $this->assertSame('foo', $values[0]->getValue());
        }
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Nickname')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\NicknameValue')
            ->findAll());

        // comma-separated values
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
NICKNAME:foo,bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importNickname();
        $this->em->flush();
        $nicknames = $vcard->getNicknames();
        $this->assertCount(1, $nicknames);
        foreach ($nicknames as $nickname) {
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Nickname', $nickname);
            $values = $nickname->getValues();
            $this->assertCount(2, $values);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\NicknameValue', $values[0]);
            $this->assertSame('foo', $values[0]->getValue());
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\NicknameValue', $values[1]);
            $this->assertSame('bar', $values[1]->getValue());
        }
        $this->assertCount(2, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Nickname')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Yalesov\Vcard\Entity\NicknameValue')
            ->findAll());

        // multiple entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
NICKNAME:foo
NICKNAME:foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importNickname();
        $this->em->flush();
        $nicknames = $vcard->getNicknames();
        $this->assertCount(2, $nicknames);
        foreach ($nicknames as $nickname) {
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Nickname', $nickname);
            $values = $nickname->getValues();
            $this->assertCount(1, $values);
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\NicknameValue', $values[0]);
            $this->assertSame('foo', $values[0]->getValue());
        }
        $this->assertCount(4, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Nickname')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Yalesov\Vcard\Entity\NicknameValue')
            ->findAll());

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
NICKNAME:
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importNickname();
        $this->em->flush();
        $nicknames = $vcard->getNicknames();
        $this->assertCount(0, $nicknames);
        $this->assertCount(4, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Nickname')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Yalesov\Vcard\Entity\NicknameValue')
            ->findAll());

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importNickname();
        $this->em->flush();
        $nicknames = $vcard->getNicknames();
        $this->assertCount(0, $nicknames);
        $this->assertCount(4, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Nickname')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Yalesov\Vcard\Entity\NicknameValue')
            ->findAll());
    }

    /**
     * @depends testParseSource
     */
    public function testImportPhoto()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
PHOTO:foo
PHOTO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addPhoto'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addPhoto');

        $this->importer->importPhoto();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
PHOTO:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addPhoto'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addPhoto');

        $this->importer->importPhoto();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addPhoto'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addPhoto');

        $this->importer->importPhoto();
    }

    /**
     * @depends testParseSource
     */
    public function testImportBirthday()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
BDAY:19900101
BDAY:19900101
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('setBirthday'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->once())
            ->method('setBirthday');

        $this->importer->importBirthday();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
BDAY:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('setBirthday'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('setBirthday');

        $this->importer->importBirthday();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('setBirthday'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('setBirthday');

        $this->importer->importBirthday();
    }

    /**
     * @depends testParseSource
     */
    public function testImportAnniversary()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
ANNIVERSARY:19900101
ANNIVERSARY:19900101
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('setAnniversary'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->once())
            ->method('setAnniversary');

        $this->importer->importAnniversary();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
ANNIVERSARY:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('setAnniversary'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('setAnniversary');

        $this->importer->importAnniversary();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('setAnniversary'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('setAnniversary');

        $this->importer->importAnniversary();
    }

    /**
     * @depends testParseSource
     */
    public function testImportGender()
    {
        $male = new Entity\GenderValue;
        $this->em->persist($male);
        $male->setValue('M');
        $this->em->flush();

        // standard gender
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
GENDER:M
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importGender();
        $this->em->flush();
        $gender = $vcard->getGender();
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Gender', $gender);
        $this->assertSame($male, $gender->getValue());
        $this->assertEmpty($gender->getComment());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GenderValue')
            ->findAll());

        // gender with comment
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
GENDER:M;comment
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importGender();
        $this->em->flush();
        $gender = $vcard->getGender();
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Gender', $gender);
        $this->assertSame($male, $gender->getValue());
        $this->assertSame('comment', $gender->getComment());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GenderValue')
            ->findAll());

        // only comment
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
GENDER:;comment
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importGender();
        $this->em->flush();
        $gender = $vcard->getGender();
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Gender', $gender);
        $this->assertEmpty($gender->getValue());
        $this->assertSame('comment', $gender->getComment());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GenderValue')
            ->findAll());

        // no gender
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importGender();
        $this->em->flush();
        $this->assertEmpty($vcard->getGender());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GenderValue')
            ->findAll());

        // undefined gender
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
GENDER:Z
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importGender();
        $this->em->flush();
        $gender = $vcard->getGender();
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Gender', $gender);
        $this->assertEmpty($gender->getValue());
        $this->assertEmpty($gender->getComment());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GenderValue')
            ->findAll());

        // undefined gender with comment
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
GENDER:Z;comment
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importGender();
        $this->em->flush();
        $gender = $vcard->getGender();
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Gender', $gender);
        $this->assertEmpty($gender->getValue());
        $this->assertSame('comment', $gender->getComment());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GenderValue')
            ->findAll());

        // standard x-gender
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
X-GENDER:Male
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importGender();
        $this->em->flush();
        $gender = $vcard->getGender();
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Gender', $gender);
        $this->assertSame($male, $gender->getValue());
        $this->assertEmpty($gender->getComment());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GenderValue')
            ->findAll());

        // standard x-gender: lowercase; short-form
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
X-GENDER:m
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importGender();
        $this->em->flush();
        $gender = $vcard->getGender();
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Gender', $gender);
        $this->assertSame($male, $gender->getValue());
        $this->assertEmpty($gender->getComment());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GenderValue')
            ->findAll());

        // undefined x-gender
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
X-GENDER:Z
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importGender();
        $this->em->flush();
        $this->assertEmpty($vcard->getGender());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GenderValue')
            ->findAll());

        // empty x-gender
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
X-GENDER:
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importGender();
        $this->em->flush();
        $this->assertEmpty($vcard->getGender());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\GenderValue')
            ->findAll());
    }

    /**
     * @depends testParseSource
     */
    public function testImportAddress()
    {
        // standard entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
ADR:pobox;ext;street;locality;region;postalcode;country
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importAddress();
        $this->em->flush();
        $addresses = $vcard->getAddresses();
        $this->assertCount(1, $addresses);
        foreach ($addresses as $address) {
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Address', $address);
            $this->assertSame("pobox\next\nstreet", $address->getStreet());
            $this->assertSame('locality', $address->getLocality());
            $this->assertSame('region', $address->getRegion());
            $this->assertSame('postalcode', $address->getPostalCode());
            $this->assertSame('country', $address->getCountry());
        }
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Address')
            ->findAll());

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
ADR:
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importAddress();
        $this->em->flush();
        $addresses = $vcard->getAddresses();
        $this->assertCount(0, $addresses);
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Address')
            ->findAll());

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importAddress();
        $this->em->flush();
        $addresses = $vcard->getAddresses();
        $this->assertCount(0, $addresses);
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Address')
            ->findAll());

        // multiple entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
ADR:pobox;ext;street;locality;region;postalcode;country
ADR:pobox;ext;street;locality;region;postalcode;country
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importAddress();
        $this->em->flush();
        $addresses = $vcard->getAddresses();
        $this->assertCount(2, $addresses);
        foreach ($addresses as $address) {
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Address', $address);
            $this->assertSame("pobox\next\nstreet", $address->getStreet());
            $this->assertSame('locality', $address->getLocality());
            $this->assertSame('region', $address->getRegion());
            $this->assertSame('postalcode', $address->getPostalCode());
            $this->assertSame('country', $address->getCountry());
        }
        $this->assertCount(3, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Address')
            ->findAll());

        // \n's
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
ADR:p\\nobox;e\\nxt;s\\ntreet;l\\nocality;r\\negion;p\\nostalcode;c\\nountry
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importAddress();
        $this->em->flush();
        $addresses = $vcard->getAddresses();
        $this->assertCount(1, $addresses);
        foreach ($addresses as $address) {
            $this->assertInstanceOf(
                'Yalesov\Vcard\Entity\Address', $address);
            $this->assertSame("p\nobox\ne\nxt\ns\ntreet", $address->getStreet());
            $this->assertSame("l\nocality", $address->getLocality());
            $this->assertSame("r\negion", $address->getRegion());
            $this->assertSame("p\nostalcode", $address->getPostalCode());
            $this->assertSame("c\nountry", $address->getCountry());
        }
        $this->assertCount(4, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Address')
            ->findAll());
    }

    /**
     * @depends testParseSource
     */
    public function testImportPhone()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
TEL;TYPE=foo:foo
TEL;TYPE=bar:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addPhone'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addPhone');

        $this->importer->importPhone();

        // test default type
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
TEL:foo
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addPhone'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(1))
            ->method('addPhone');

        $this->importer->importPhone();

        $this->assertSame(
            Repository\PhoneType::DEF, (string) $card->TEL['TYPE']);

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
TEL:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addPhone'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addPhone');

        $this->importer->importPhone();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addPhone'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addPhone');

        $this->importer->importPhone();
    }

    /**
     * @depends testParseSource
     */
    public function testImportEmail()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
EMAIL:foo
EMAIL:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addEmail'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addEmail');

        $this->importer->importEmail();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
EMAIL:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addEmail'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addEmail');

        $this->importer->importEmail();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addEmail'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addEmail');

        $this->importer->importEmail();
    }

    /**
     * @depends testParseSource
     */
    public function testImportIm()
    {
        $jabber = new Entity\ImProtocol;
        $jabber->setValue(Repository\ImProtocol::JABBER);
        $this->em->persist($jabber);

        // standard entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
IMPP:foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importIm();
        $this->em->flush();
        $ims = $vcard->getIms();
        $this->assertCount(1, $ims);
        $this->assertInstanceOf('Yalesov\Vcard\Entity\Im', $ims[0]);
        $this->assertSame('foo', $ims[0]->getValue());
        $this->assertEmpty($ims[0]->getProtocol());
        $this->assertEquals(false, $ims[0]->getIsUri());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Im')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\ImProtocol')
            ->findAll());

        // non-standard entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
X-JABBER:foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importIm();
        $this->em->flush();
        $ims = $vcard->getIms();
        $this->assertCount(1, $ims);
        $this->assertInstanceOf('Yalesov\Vcard\Entity\Im', $ims[0]);
        $this->assertSame('foo', $ims[0]->getValue());
        $this->assertSame($jabber, $ims[0]->getProtocol());
        $this->assertEquals(false, $ims[0]->getIsUri());
        $this->assertCount(2, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Im')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\ImProtocol')
            ->findAll());

        // combined formats
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
IMPP:foo
X-JABBER:foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importIm();
        $this->em->flush();
        $ims = $vcard->getIms();
        $this->assertCount(2, $ims);
        $this->assertInstanceOf('Yalesov\Vcard\Entity\Im', $ims[0]);
        $this->assertSame('foo', $ims[0]->getValue());
        $this->assertEmpty($ims[0]->getProtocol());
        $this->assertEquals(false, $ims[0]->getIsUri());
        $this->assertInstanceOf('Yalesov\Vcard\Entity\Im', $ims[1]);
        $this->assertSame('foo', $ims[1]->getValue());
        $this->assertSame($jabber, $ims[1]->getProtocol());
        $this->assertEquals(false, $ims[1]->getIsUri());
        $this->assertCount(4, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Im')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\ImProtocol')
            ->findAll());

        // detect protocol
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
IMPP:gtalk://foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importIm();
        $this->em->flush();
        $ims = $vcard->getIms();
        $this->assertCount(1, $ims);
        $this->assertInstanceOf('Yalesov\Vcard\Entity\Im', $ims[0]);
        $this->assertSame('gtalk://foo', $ims[0]->getValue());
        $this->assertSame($jabber, $ims[0]->getProtocol());
        $this->assertTrue($ims[0]->getIsUri());
        $this->assertCount(5, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Im')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\ImProtocol')
            ->findAll());

        // no protocol detection for non-standard properties, even on conflict
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
X-JABBER:msnim://foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importIm();
        $this->em->flush();
        $ims = $vcard->getIms();
        $this->assertCount(1, $ims);
        $this->assertInstanceOf('Yalesov\Vcard\Entity\Im', $ims[0]);
        $this->assertSame('msnim://foo', $ims[0]->getValue());
        $this->assertSame($jabber, $ims[0]->getProtocol());
        $this->assertEquals(false, $ims[0]->getIsUri());
        $this->assertCount(6, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Im')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\ImProtocol')
            ->findAll());

        // empty entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
IMPP:
X-JABBER:
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importIm();
        $this->em->flush();
        $ims = $vcard->getIms();
        $this->assertCount(0, $ims);
        $this->assertCount(6, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Im')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\ImProtocol')
            ->findAll());

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importIm();
        $this->em->flush();
        $ims = $vcard->getIms();
        $this->assertCount(0, $ims);
        $this->assertCount(6, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Im')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\ImProtocol')
            ->findAll());
    }

    /**
     * @depends testParseSource
     */
    public function testImportLanguage()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
LANG:foo
LANG:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addLanguage'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addLanguage');

        $this->importer->importLanguage();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
LANG:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addLanguage'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addLanguage');

        $this->importer->importLanguage();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addLanguage'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addLanguage');

        $this->importer->importLanguage();
    }

    /**
     * @depends testParseSource
     */
    public function testImportTimezone()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
TZ:foo
TZ:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addTimezone'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addTimezone');

        $this->importer->importTimezone();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
TZ:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addTimezone'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addTimezone');

        $this->importer->importTimezone();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addTimezone'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addTimezone');

        $this->importer->importTimezone();
    }

    /**
     * @depends testParseSource
     */
    public function testImportGeo()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
GEO:foo
GEO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addGeo'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addGeo');

        $this->importer->importGeo();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
GEO:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addGeo'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addGeo');

        $this->importer->importGeo();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addGeo'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addGeo');

        $this->importer->importGeo();
    }

    /**
     * @depends testParseSource
     */
    public function testImportTitle()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
TITLE:foo
TITLE:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addTitle'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addTitle');

        $this->importer->importTitle();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
TITLE:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addTitle'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addTitle');

        $this->importer->importTitle();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addTitle'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addTitle');

        $this->importer->importTitle();
    }

    /**
     * @depends testParseSource
     */
    public function testImportRole()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
ROLE:foo
ROLE:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addRole'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addRole');

        $this->importer->importRole();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
ROLE:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addRole'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addRole');

        $this->importer->importRole();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addRole'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addRole');

        $this->importer->importRole();
    }

    /**
     * @depends testParseSource
     */
    public function testImportLogo()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
LOGO:foo
LOGO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addLogo'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addLogo');

        $this->importer->importLogo();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
LOGO:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addLogo'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addLogo');

        $this->importer->importLogo();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addLogo'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addLogo');

        $this->importer->importLogo();
    }

    /**
     * @depends testParseSource
     */
    public function testImportOrg()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
ORG:foo
ORG:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addOrg'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addOrg');

        $this->importer->importOrg();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
ORG:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addOrg'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addOrg');

        $this->importer->importOrg();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addOrg'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addOrg');

        $this->importer->importOrg();
    }

    /**
     * @depends testParseSource
     */
    public function testImportMember()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
MEMBER:foo
MEMBER:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addMember'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addMember');

        $this->importer->importMember();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
MEMBER:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addMember'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addMember');

        $this->importer->importMember();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addMember'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addMember');

        $this->importer->importMember();
    }

    /**
     * @depends testParseSource
     */
    public function testImportRelation()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
RELATED;TYPE=foo:foo
RELATED;TYPE=bar:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addRelation'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addRelation');

        $this->importer->importRelation();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
RELATED:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addRelation'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addRelation');

        $this->importer->importRelation();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addRelation'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addRelation');

        $this->importer->importRelation();
    }

    /**
     * @depends testParseSource
     */
    public function testImportTag()
    {
        // standard entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
CATEGORIES:foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importTag();
        $this->em->flush();
        $tags = $vcard->getTags();
        $this->assertCount(1, $tags);
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Tag', $tags[0]);
        $values = $tags[0]->getValues();
        $this->assertCount(1, $values);
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\TagValue', $values[0]);
        $this->assertSame('foo', $values[0]->getValue());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Tag')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Yalesov\Vcard\Entity\TagValue')
            ->findAll());

        // comma-separated values
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
CATEGORIES:foo,bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importTag();
        $this->em->flush();
        $tags = $vcard->getTags();
        $this->assertCount(1, $tags);
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Tag', $tags[0]);
        $values = $tags[0]->getValues();
        $this->assertCount(2, $values);
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\TagValue', $values[0]);
        $this->assertSame('foo', $values[0]->getValue());
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\TagValue', $values[1]);
        $this->assertSame('bar', $values[1]->getValue());
        $this->assertCount(2, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Tag')
            ->findAll());
        $this->assertCount(2, $this->em
            ->getRepository('Yalesov\Vcard\Entity\TagValue')
            ->findAll());

        // multiple entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
CATEGORIES:foo
CATEGORIES:bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importTag();
        $this->em->flush();
        $tags = $vcard->getTags();
        $this->assertCount(2, $tags);
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Tag', $tags[0]);
        $values = $tags[0]->getValues();
        $this->assertCount(1, $values);
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\TagValue', $values[0]);
        $this->assertSame('foo', $values[0]->getValue());
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Tag', $tags[1]);
        $values = $tags[1]->getValues();
        $this->assertCount(1, $values);
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\TagValue', $values[0]);
        $this->assertSame('bar', $values[0]->getValue());
        $this->assertCount(4, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Tag')
            ->findAll());
        $this->assertCount(2, $this->em
            ->getRepository('Yalesov\Vcard\Entity\TagValue')
            ->findAll());

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
CATEGORIES:
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importTag();
        $this->em->flush();
        $tags = $vcard->getTags();
        $this->assertCount(0, $tags);
        $this->assertCount(4, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Tag')
            ->findAll());
        $this->assertCount(2, $this->em
            ->getRepository('Yalesov\Vcard\Entity\TagValue')
            ->findAll());

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->importer
            ->setCard($card)
            ->setVcard($vcard)
            ->importTag();
        $this->em->flush();
        $tags = $vcard->getTags();
        $this->assertCount(0, $tags);
        $this->assertCount(4, $this->em
            ->getRepository('Yalesov\Vcard\Entity\Tag')
            ->findAll());
        $this->assertCount(2, $this->em
            ->getRepository('Yalesov\Vcard\Entity\TagValue')
            ->findAll());
    }

    /**
     * @depends testParseSource
     */
    public function testImportNote()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
NOTE:foo
NOTE:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addNote'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addNote');

        $this->importer->importNote();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
NOTE:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addNote'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addNote');

        $this->importer->importNote();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addNote'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addNote');

        $this->importer->importNote();
    }

    /**
     * @depends testParseSource
     */
    public function testImportSound()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
SOUND:foo
SOUND:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addSound'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addSound');

        $this->importer->importSound();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
SOUND:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addSound'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addSound');

        $this->importer->importSound();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addSound'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addSound');

        $this->importer->importSound();
    }

    /**
     * @depends testParseSource
     */
    public function testImportUid()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
UID:foo
UID:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('setUid'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->once())
            ->method('setUid');

        $this->importer->importUid();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
UID:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('setUid'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('setUid');

        $this->importer->importUid();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('setUid'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('setUid');

        $this->importer->importUid();
    }

    /**
     * @depends testParseSource
     */
    public function testImportUrl()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
URL:foo
URL:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addUrl'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addUrl');

        $this->importer->importUrl();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
URL:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addUrl'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addUrl');

        $this->importer->importUrl();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addUrl'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addUrl');

        $this->importer->importUrl();
    }

    /**
     * @depends testParseSource
     */
    public function testImportPublicKey()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
KEY:foo
KEY:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addPublicKey'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addPublicKey');

        $this->importer->importPublicKey();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
KEY:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addPublicKey'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addPublicKey');

        $this->importer->importPublicKey();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addPublicKey'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addPublicKey');

        $this->importer->importPublicKey();
    }

    /**
     * @depends testParseSource
     */
    public function testImportFreebusy()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FBURL:foo
FBURL:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addFreebusy'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addFreebusy');

        $this->importer->importFreebusy();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FBURL:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addFreebusy'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addFreebusy');

        $this->importer->importFreebusy();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addFreebusy'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addFreebusy');

        $this->importer->importFreebusy();
    }

    /**
     * @depends testParseSource
     */
    public function testImportCalendar()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
CALURI:foo
CALURI:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addCalendar'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addCalendar');

        $this->importer->importCalendar();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
CALURI:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addCalendar'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addCalendar');

        $this->importer->importCalendar();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addCalendar'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addCalendar');

        $this->importer->importCalendar();
    }

    /**
     * @depends testParseSource
     */
    public function testImportCalendarRequest()
    {
        // standard entries
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
CALADRURI:foo
CALADRURI:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addCalendarRequest'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addCalendarRequest');

        $this->importer->importCalendarRequest();

        // empty entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
CALADRURI:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addCalendarRequest'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addCalendarRequest');

        $this->importer->importCalendarRequest();

        // no entry
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Yalesov\Vcard\Entity\Vcard', array('addCalendarRequest'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addCalendarRequest');

        $this->importer->importCalendarRequest();
    }

    public function testImport()
    {
        $this->assertInstanceOf(
            'Yalesov\Vcard\Entity\Vcard',
            $this->importer->import(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        ));
    }
}
