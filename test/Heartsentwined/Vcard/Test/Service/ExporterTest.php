<?php
namespace Heartsentwined\Vcard\Test\Service;

use Heartsentwined\DateTimeParser\Parser as DateTimeParser;
use Heartsentwined\Vcard\Entity;
use Heartsentwined\Vcard\Repository;
use Heartsentwined\Vcard\Service\Exporter;
use Heartsentwined\Phpunit\Testcase\Doctrine as DoctrineTestcase;

class ExporterTest extends DoctrineTestcase
{
    public function setUp()
    {
        $this
            ->setBootstrap(__DIR__ . '/../../../../../bootstrap.php')
            ->setEmAlias('doctrine.entitymanager.orm_default')
            ->setTmpDir('tmp');
        parent::setUp();

        $this->exporter = $this->sm->get('vcard-exporter')
            ->setEm($this->em)
            ->setDateTimeParser(
                $this->sm->get('Heartsentwined\DateTimeParser\Parser'));
    }

    public function tearDown()
    {
        $this->exporter = null;
        parent::tearDown();
    }

    public function testCreateCard()
    {
        $card = $this->exporter->createCard();
        $this->assertInstanceOf('Sabre\VObject\Node', $card);
        $this->assertSame(Repository\Vcard::VERSION, (string) $card->VERSION);
    }

    public function testNormalizeSource()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        $this->assertSame('', $this->exporter->normalizeSource(''));
        $this->assertSame("BEGIN:\né",
            $this->exporter->normalizeSource("BEGIN:\n<u+00e9>"));
        $this->assertSame(<<<STR
BEGIN:VCARD
 foo
STR
            , $this->exporter->normalizeSource(<<<STR
BEGIN:VCARD
        foo
STR
        ));
         */
    }

    public function testParseSource()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        $this->assertInstanceOf(
            'Sabre\VObject\Node',
            $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
            ));
         */
    }

    public function testExportParam()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
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

        $card = $this->exporter->parseSource(<<<STR
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

        $param = $this->exporter->exportParam($card->ALL);
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

        $param = $this->exporter->exportParam($card->ALLEMPTY);
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

        $param = $this->exporter->exportParam($card->{'VALUE-OLD'});
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

        $param = $this->exporter->exportParam($card->{'VALUE-NEW'});
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

        $param = $this->exporter->exportParam($card->{'VALUE-EMPTY'});
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

        $param = $this->exporter->exportParam($card->{'TYPE-COMMA'});
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

        $param = $this->exporter->exportParam($card->{'TYPE-NEW'});
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

        $param = $this->exporter->exportParam($card->{'TYPE-EMPTY'});
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
         */
    }

    public function testExportMultiple()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
ORG;LANGUAGE=foo:foo
ORG;LANGUAGE=bar:bar
END:VCARD
STR
        );

        $orgs = $this->exporter->exportMultiple(
            $card->ORG, 'Heartsentwined\Vcard\Entity\Org');
        $this->em->flush();
        $this->assertCount(2, $orgs);
        $this->assertCount(2, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Org')->findAll());

        $foo = $orgs[0];
        $bar = $orgs[1];

        $this->assertSame('foo', $foo->getValue());
        $this->assertSame('bar', $bar->getValue());
         */
    }

    public function testExportMultipleWithType()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // simple entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
TEL;TYPE=foo:123
TEL;TYPE=bar:456
END:VCARD
STR
        );

        $phones = $this->exporter->exportMultipleWithType(
            $card->TEL, 'Heartsentwined\Vcard\Entity\Phone');
        $this->em->flush();
        $this->assertCount(2, $phones);
        $this->assertCount(2, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Phone')->findAll());
        $this->assertCount(2, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\PhoneType')
            ->findAll());

        $this->assertSame('123', $phones[0]->getValue());
        $types = $phones[0]->getPhoneTypes();
        $this->assertCount(1, $types);
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\PhoneType', $types[0]);
        $this->assertSame('foo', $types[0]->getValue());

        $this->assertSame('456', $phones[1]->getValue());
        $types = $phones[1]->getPhoneTypes();
        $this->assertCount(1, $types);
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\PhoneType', $types[0]);
        $this->assertSame('bar', $types[0]->getValue());

        // different type syntaxes
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
TEL;TYPE=foo;TYPE=bar;TYPE=baz,qux:123
END:VCARD
STR
        );

        $phones = $this->exporter->exportMultipleWithType(
            $card->TEL, 'Heartsentwined\Vcard\Entity\Phone');
        $this->em->flush();
        $this->assertCount(1, $phones);
        $this->assertCount(3, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Phone')->findAll());
        $this->assertCount(4, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\PhoneType')
            ->findAll());

        $this->assertSame('123', $phones[0]->getValue());
        $types = $phones[0]->getPhoneTypes();
        $this->assertCount(4, $types);
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\PhoneType', $types[0]);
        $this->assertSame('foo', $types[0]->getValue());
        $this->assertSame('bar', $types[1]->getValue());
        $this->assertSame('baz', $types[2]->getValue());
        $this->assertSame('qux', $types[3]->getValue());
         */
    }

    public function testExportSingleDateTime()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // full date
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
BDAY:19900101T010101Z
BDAY:19900101T010101Z
END:VCARD
STR
        );

        $birthday = $this->exporter->exportSingleDatetime(
            $card->BDAY, 'Heartsentwined\Vcard\Entity\Birthday');
        $this->em->flush();
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Birthday')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\DateTimeText')
            ->findAll());

        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Birthday', $birthday);
        $dateTimeText = $birthday->getValue();
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\DateTimeText', $dateTimeText);
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
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
BDAY:--0101
BDAY:--0101
END:VCARD
STR
        );

        $birthday = $this->exporter->exportSingleDatetime(
            $card->BDAY, 'Heartsentwined\Vcard\Entity\Birthday');
        $this->em->flush();
        $this->assertCount(2, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Birthday')
            ->findAll());
        $this->assertCount(2, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\DateTimeText')
            ->findAll());

        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Birthday', $birthday);
        $dateTimeText = $birthday->getValue();
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\DateTimeText', $dateTimeText);
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
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
BDAY;VALUE=text:foo
BDAY;VALUE=text:foo
END:VCARD
STR
        );

        $birthday = $this->exporter->exportSingleDatetime(
            $card->BDAY, 'Heartsentwined\Vcard\Entity\Birthday');
        $this->em->flush();
        $this->assertCount(3, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Birthday')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\DateTimeText')
            ->findAll());

        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Birthday', $birthday);
        $dateTimeText = $birthday->getValue();
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\DateTimeText', $dateTimeText);
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
         */
    }

    public function testExportSingle()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
ORG;LANGUAGE=foo:foo
ORG;LANGUAGE=bar:bar
END:VCARD
STR
        );

        $foo = $this->exporter->exportSingle(
            $card->ORG, 'Heartsentwined\Vcard\Entity\Org');
        $this->em->flush();
        $this->assertInstanceOf('Heartsentwined\Vcard\Entity\Org', $foo);
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Org')->findAll());

        $this->assertSame('foo', $foo->getValue());
         */
    }

    public function testExportSource()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
SOURCE:foo
SOURCE:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addSource'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addSource');

        $this->exporter->exportSource();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
SOURCE:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addSource'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addSource');

        $this->exporter->exportSource();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addSource'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addSource');

        $this->exporter->exportSource();
         */
    }

    public function testExportKind()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        $default = Repository\KindValue::DEF;
        $defaultValue = new Entity\KindValue;
        $this->em->persist($defaultValue);
        $defaultValue->setValue($default);
        $this->em->flush();

        // default value
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
KIND:$default
END:VCARD
STR
        );

        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportKind();
        $this->em->flush();
        $kind = $vcard->getKind();
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Kind', $kind);
        $this->assertSame($defaultValue, $kind->getValue());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\KindValue')
            ->findAll());

        // empty: assume default
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
KIND:
END:VCARD
STR
        );

        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportKind();
        $this->em->flush();
        $kind = $vcard->getKind();
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Kind', $kind);
        $this->assertSame($defaultValue, $kind->getValue());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\KindValue')
            ->findAll());

        // new kind
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
KIND:foo
END:VCARD
STR
        );

        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportKind();
        $this->em->flush();
        $kind = $vcard->getKind();
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Kind', $kind);
        $kindValue = $kind->getValue();
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\KindValue', $kindValue);
        $this->assertSame('foo', $kindValue->getValue());
        $this->assertCount(2, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\KindValue')
            ->findAll());

        // no kind: assume default
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportKind();
        $this->em->flush();
        $kind = $vcard->getKind();
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Kind', $kind);
        $this->assertSame($defaultValue, $kind->getValue());
        $this->assertCount(2, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\KindValue')
            ->findAll());
         */
    }

    public function testExportFormattedName()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FN:foo
FN:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addFormattedName'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addFormattedName');

        $this->exporter->exportFormattedName();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FN:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addFormattedName'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addFormattedName');

        $this->exporter->exportFormattedName();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addFormattedName'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addFormattedName');

        $this->exporter->exportFormattedName();
         */
    }

    public function testExportName()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
N:family;given;additional;prefix;suffix
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportName();
        $this->em->flush();
        $names = $vcard->getNames();
        $this->assertCount(1, $names);
        foreach ($names as $name) {
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Name', $name);
            $familyNames = $name->getFamilyNames();
            $this->assertCount(1, $familyNames);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\FamilyName', $familyNames[0]);
            $this->assertSame('family', $familyNames[0]->getValue());

            $givenNames = $name->getGivenNames();
            $this->assertCount(1, $givenNames);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\GivenName', $givenNames[0]);
            $this->assertSame('given', $givenNames[0]->getValue());

            $additionalNames = $name->getAdditionalNames();
            $this->assertCount(1, $additionalNames);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\AdditionalName',
                $additionalNames[0]);
            $this->assertSame('additional', $additionalNames[0]->getValue());

            $prefixes = $name->getPrefixes();
            $this->assertCount(1, $prefixes);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Prefix', $prefixes[0]);
            $this->assertSame('prefix', $prefixes[0]->getValue());

            $suffixes = $name->getSuffixes();
            $this->assertCount(1, $suffixes);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Suffix', $suffixes[0]);
            $this->assertSame('suffix', $suffixes[0]->getValue());
        }
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Name')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\FamilyName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GivenName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\AdditionalName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Prefix')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Suffix')
            ->findAll());

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
N:
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportName();
        $this->em->flush();
        $names = $vcard->getNames();
        $this->assertCount(0, $names);
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Name')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\FamilyName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GivenName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\AdditionalName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Prefix')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Suffix')
            ->findAll());

        // empty components
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
N:;;;;
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportName();
        $this->em->flush();
        $names = $vcard->getNames();
        $this->assertCount(1, $names);
        foreach ($names as $name) {
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Name', $name);
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
            ->getRepository('Heartsentwined\Vcard\Entity\Name')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\FamilyName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GivenName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\AdditionalName')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Prefix')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Suffix')
            ->findAll());

        // multiple components
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
N:family1,family2;given1,given2;add1,add2;prefix1,prefix2;suffix1,suffix2
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportName();
        $this->em->flush();
        $names = $vcard->getNames();
        $this->assertCount(1, $names);
        foreach ($names as $name) {
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Name', $name);
            $familyNames = $name->getFamilyNames();
            $this->assertCount(2, $familyNames);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\FamilyName', $familyNames[0]);
            $this->assertSame('family1', $familyNames[0]->getValue());
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\FamilyName', $familyNames[1]);
            $this->assertSame('family2', $familyNames[1]->getValue());

            $givenNames = $name->getGivenNames();
            $this->assertCount(2, $givenNames);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\GivenName', $givenNames[0]);
            $this->assertSame('given1', $givenNames[0]->getValue());
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\GivenName', $givenNames[1]);
            $this->assertSame('given2', $givenNames[1]->getValue());

            $additionalNames = $name->getAdditionalNames();
            $this->assertCount(2, $additionalNames);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\AdditionalName',
                $additionalNames[0]);
            $this->assertSame('add1', $additionalNames[0]->getValue());
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\AdditionalName',
                $additionalNames[1]);
            $this->assertSame('add2', $additionalNames[1]->getValue());

            $prefixes = $name->getPrefixes();
            $this->assertCount(2, $prefixes);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Prefix', $prefixes[0]);
            $this->assertSame('prefix1', $prefixes[0]->getValue());
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Prefix', $prefixes[1]);
            $this->assertSame('prefix2', $prefixes[1]->getValue());

            $suffixes = $name->getSuffixes();
            $this->assertCount(2, $suffixes);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Suffix', $suffixes[0]);
            $this->assertSame('suffix1', $suffixes[0]->getValue());
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Suffix', $suffixes[1]);
            $this->assertSame('suffix2', $suffixes[1]->getValue());
        }
        $this->assertCount(3, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Name')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\FamilyName')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GivenName')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\AdditionalName')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Prefix')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Suffix')
            ->findAll());

        // missing components
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
N:family;given
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportName();
        $this->em->flush();
        $names = $vcard->getNames();
        $this->assertCount(1, $names);
        foreach ($names as $name) {
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Name', $name);
            $familyNames = $name->getFamilyNames();
            $this->assertCount(1, $familyNames);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\FamilyName', $familyNames[0]);
            $this->assertSame('family', $familyNames[0]->getValue());

            $givenNames = $name->getGivenNames();
            $this->assertCount(1, $givenNames);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\GivenName', $givenNames[0]);
            $this->assertSame('given', $givenNames[0]->getValue());

            $additionalNames = $name->getAdditionalNames();
            $this->assertCount(0, $additionalNames);

            $prefixes = $name->getPrefixes();
            $this->assertCount(0, $prefixes);

            $suffixes = $name->getSuffixes();
            $this->assertCount(0, $suffixes);
        }
        $this->assertCount(4, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Name')
            ->findAll());
        $this->assertCount(4, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\FamilyName')
            ->findAll());
        $this->assertCount(4, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GivenName')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\AdditionalName')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Prefix')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Suffix')
            ->findAll());

        // multiple entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
N:family;given;additional;prefix;suffix
N:family;given;additional;prefix;suffix
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportName();
        $this->em->flush();
        $names = $vcard->getNames();
        $this->assertCount(2, $names);
        foreach ($names as $name) {
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Name', $name);
            $familyNames = $name->getFamilyNames();
            $this->assertCount(1, $familyNames);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\FamilyName', $familyNames[0]);
            $this->assertSame('family', $familyNames[0]->getValue());

            $givenNames = $name->getGivenNames();
            $this->assertCount(1, $givenNames);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\GivenName', $givenNames[0]);
            $this->assertSame('given', $givenNames[0]->getValue());

            $additionalNames = $name->getAdditionalNames();
            $this->assertCount(1, $additionalNames);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\AdditionalName',
                $additionalNames[0]);
            $this->assertSame('additional', $additionalNames[0]->getValue());

            $prefixes = $name->getPrefixes();
            $this->assertCount(1, $prefixes);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Prefix', $prefixes[0]);
            $this->assertSame('prefix', $prefixes[0]->getValue());

            $suffixes = $name->getSuffixes();
            $this->assertCount(1, $suffixes);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Suffix', $suffixes[0]);
            $this->assertSame('suffix', $suffixes[0]->getValue());
        }
        $this->assertCount(6, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Name')
            ->findAll());
        $this->assertCount(6, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\FamilyName')
            ->findAll());
        $this->assertCount(6, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GivenName')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\AdditionalName')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Prefix')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Suffix')
            ->findAll());

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportName();
        $this->em->flush();
        $names = $vcard->getNames();
        $this->assertCount(0, $names);
        $this->assertCount(6, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Name')
            ->findAll());
        $this->assertCount(6, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\FamilyName')
            ->findAll());
        $this->assertCount(6, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GivenName')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\AdditionalName')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Prefix')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Suffix')
            ->findAll());
         */
    }

    public function testExportNickname()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
NICKNAME:foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportNickname();
        $this->em->flush();
        $nicknames = $vcard->getNicknames();
        $this->assertCount(1, $nicknames);
        foreach ($nicknames as $nickname) {
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Nickname', $nickname);
            $values = $nickname->getValues();
            $this->assertCount(1, $values);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\NicknameValue', $values[0]);
            $this->assertSame('foo', $values[0]->getValue());
        }
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Nickname')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\NicknameValue')
            ->findAll());

        // comma-separated values
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
NICKNAME:foo,bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportNickname();
        $this->em->flush();
        $nicknames = $vcard->getNicknames();
        $this->assertCount(1, $nicknames);
        foreach ($nicknames as $nickname) {
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Nickname', $nickname);
            $values = $nickname->getValues();
            $this->assertCount(2, $values);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\NicknameValue', $values[0]);
            $this->assertSame('foo', $values[0]->getValue());
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\NicknameValue', $values[1]);
            $this->assertSame('bar', $values[1]->getValue());
        }
        $this->assertCount(2, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Nickname')
            ->findAll());
        $this->assertCount(3, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\NicknameValue')
            ->findAll());

        // multiple entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
NICKNAME:foo
NICKNAME:foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportNickname();
        $this->em->flush();
        $nicknames = $vcard->getNicknames();
        $this->assertCount(2, $nicknames);
        foreach ($nicknames as $nickname) {
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Nickname', $nickname);
            $values = $nickname->getValues();
            $this->assertCount(1, $values);
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\NicknameValue', $values[0]);
            $this->assertSame('foo', $values[0]->getValue());
        }
        $this->assertCount(4, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Nickname')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\NicknameValue')
            ->findAll());

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
NICKNAME:
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportNickname();
        $this->em->flush();
        $nicknames = $vcard->getNicknames();
        $this->assertCount(0, $nicknames);
        $this->assertCount(4, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Nickname')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\NicknameValue')
            ->findAll());

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportNickname();
        $this->em->flush();
        $nicknames = $vcard->getNicknames();
        $this->assertCount(0, $nicknames);
        $this->assertCount(4, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Nickname')
            ->findAll());
        $this->assertCount(5, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\NicknameValue')
            ->findAll());
         */
    }

    public function testExportPhoto()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
PHOTO:foo
PHOTO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addPhoto'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addPhoto');

        $this->exporter->exportPhoto();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
PHOTO:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addPhoto'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addPhoto');

        $this->exporter->exportPhoto();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addPhoto'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addPhoto');

        $this->exporter->exportPhoto();
         */
    }

    public function testExportBirthday()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
BDAY:19900101
BDAY:19900101
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('setBirthday'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->once())
            ->method('setBirthday');

        $this->exporter->exportBirthday();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
BDAY:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('setBirthday'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('setBirthday');

        $this->exporter->exportBirthday();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('setBirthday'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('setBirthday');

        $this->exporter->exportBirthday();
         */
    }

    public function testExportAnniversary()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
ANNIVERSARY:19900101
ANNIVERSARY:19900101
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('setAnniversary'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->once())
            ->method('setAnniversary');

        $this->exporter->exportAnniversary();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
ANNIVERSARY:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('setAnniversary'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('setAnniversary');

        $this->exporter->exportAnniversary();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('setAnniversary'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('setAnniversary');

        $this->exporter->exportAnniversary();
         */
    }

    public function testExportGender()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        $male = new Entity\GenderValue;
        $this->em->persist($male);
        $male->setValue('M');
        $this->em->flush();

        // standard gender
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
GENDER:M
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportGender();
        $this->em->flush();
        $gender = $vcard->getGender();
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Gender', $gender);
        $this->assertSame($male, $gender->getValue());
        $this->assertEmpty($gender->getComment());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GenderValue')
            ->findAll());

        // gender with comment
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
GENDER:M;comment
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportGender();
        $this->em->flush();
        $gender = $vcard->getGender();
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Gender', $gender);
        $this->assertSame($male, $gender->getValue());
        $this->assertSame('comment', $gender->getComment());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GenderValue')
            ->findAll());

        // only comment
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
GENDER:;comment
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportGender();
        $this->em->flush();
        $gender = $vcard->getGender();
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Gender', $gender);
        $this->assertEmpty($gender->getValue());
        $this->assertSame('comment', $gender->getComment());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GenderValue')
            ->findAll());

        // no gender
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportGender();
        $this->em->flush();
        $this->assertEmpty($vcard->getGender());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GenderValue')
            ->findAll());

        // undefined gender
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
GENDER:Z
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportGender();
        $this->em->flush();
        $gender = $vcard->getGender();
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Gender', $gender);
        $this->assertEmpty($gender->getValue());
        $this->assertEmpty($gender->getComment());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GenderValue')
            ->findAll());

        // undefined gender with comment
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
GENDER:Z;comment
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportGender();
        $this->em->flush();
        $gender = $vcard->getGender();
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Gender', $gender);
        $this->assertEmpty($gender->getValue());
        $this->assertSame('comment', $gender->getComment());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GenderValue')
            ->findAll());

        // standard x-gender
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
X-GENDER:Male
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportGender();
        $this->em->flush();
        $gender = $vcard->getGender();
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Gender', $gender);
        $this->assertSame($male, $gender->getValue());
        $this->assertEmpty($gender->getComment());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GenderValue')
            ->findAll());

        // standard x-gender: lowercase; short-form
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
X-GENDER:m
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportGender();
        $this->em->flush();
        $gender = $vcard->getGender();
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Gender', $gender);
        $this->assertSame($male, $gender->getValue());
        $this->assertEmpty($gender->getComment());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GenderValue')
            ->findAll());

        // undefined x-gender
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
X-GENDER:Z
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportGender();
        $this->em->flush();
        $this->assertEmpty($vcard->getGender());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GenderValue')
            ->findAll());

        // empty x-gender
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
X-GENDER:
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportGender();
        $this->em->flush();
        $this->assertEmpty($vcard->getGender());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\GenderValue')
            ->findAll());
         */
    }

    public function testExportAddress()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
ADR:pobox;ext;street;locality;region;postalcode;country
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportAddress();
        $this->em->flush();
        $addresses = $vcard->getAddresses();
        $this->assertCount(1, $addresses);
        foreach ($addresses as $address) {
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Address', $address);
            $this->assertSame("pobox\next\nstreet", $address->getStreet());
            $this->assertSame('locality', $address->getLocality());
            $this->assertSame('region', $address->getRegion());
            $this->assertSame('postalcode', $address->getPostalCode());
            $this->assertSame('country', $address->getCountry());
        }
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Address')
            ->findAll());

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
ADR:
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportAddress();
        $this->em->flush();
        $addresses = $vcard->getAddresses();
        $this->assertCount(0, $addresses);
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Address')
            ->findAll());

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportAddress();
        $this->em->flush();
        $addresses = $vcard->getAddresses();
        $this->assertCount(0, $addresses);
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Address')
            ->findAll());

        // multiple entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
ADR:pobox;ext;street;locality;region;postalcode;country
ADR:pobox;ext;street;locality;region;postalcode;country
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportAddress();
        $this->em->flush();
        $addresses = $vcard->getAddresses();
        $this->assertCount(2, $addresses);
        foreach ($addresses as $address) {
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Address', $address);
            $this->assertSame("pobox\next\nstreet", $address->getStreet());
            $this->assertSame('locality', $address->getLocality());
            $this->assertSame('region', $address->getRegion());
            $this->assertSame('postalcode', $address->getPostalCode());
            $this->assertSame('country', $address->getCountry());
        }
        $this->assertCount(3, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Address')
            ->findAll());

        // \n's
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
ADR:p\\nobox;e\\nxt;s\\ntreet;l\\nocality;r\\negion;p\\nostalcode;c\\nountry
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportAddress();
        $this->em->flush();
        $addresses = $vcard->getAddresses();
        $this->assertCount(1, $addresses);
        foreach ($addresses as $address) {
            $this->assertInstanceOf(
                'Heartsentwined\Vcard\Entity\Address', $address);
            $this->assertSame("p\nobox\ne\nxt\ns\ntreet", $address->getStreet());
            $this->assertSame("l\nocality", $address->getLocality());
            $this->assertSame("r\negion", $address->getRegion());
            $this->assertSame("p\nostalcode", $address->getPostalCode());
            $this->assertSame("c\nountry", $address->getCountry());
        }
        $this->assertCount(4, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Address')
            ->findAll());
         */
    }

    public function testExportPhone()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
TEL;TYPE=foo:foo
TEL;TYPE=bar:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addPhone'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addPhone');

        $this->exporter->exportPhone();

        // test default type
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
TEL:foo
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addPhone'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(1))
            ->method('addPhone');

        $this->exporter->exportPhone();

        $this->assertSame(
            Repository\PhoneType::DEF, (string) $card->TEL['TYPE']);

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
TEL:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addPhone'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addPhone');

        $this->exporter->exportPhone();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addPhone'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addPhone');

        $this->exporter->exportPhone();
         */
    }

    public function testExportEmail()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
EMAIL:foo
EMAIL:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addEmail'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addEmail');

        $this->exporter->exportEmail();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
EMAIL:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addEmail'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addEmail');

        $this->exporter->exportEmail();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addEmail'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addEmail');

        $this->exporter->exportEmail();
         */
    }

    public function testExportIm()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        $jabber = new Entity\ImProtocol;
        $jabber->setValue(Repository\ImProtocol::JABBER);
        $this->em->persist($jabber);

        // standard entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
IMPP:foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportIm();
        $this->em->flush();
        $ims = $vcard->getIms();
        $this->assertCount(1, $ims);
        $this->assertInstanceOf('Heartsentwined\Vcard\Entity\Im', $ims[0]);
        $this->assertSame('foo', $ims[0]->getValue());
        $this->assertEmpty($ims[0]->getProtocol());
        $this->assertEquals(false, $ims[0]->getIsUri());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Im')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\ImProtocol')
            ->findAll());

        // non-standard entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
X-JABBER:foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportIm();
        $this->em->flush();
        $ims = $vcard->getIms();
        $this->assertCount(1, $ims);
        $this->assertInstanceOf('Heartsentwined\Vcard\Entity\Im', $ims[0]);
        $this->assertSame('foo', $ims[0]->getValue());
        $this->assertSame($jabber, $ims[0]->getProtocol());
        $this->assertEquals(false, $ims[0]->getIsUri());
        $this->assertCount(2, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Im')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\ImProtocol')
            ->findAll());

        // combined formats
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
IMPP:foo
X-JABBER:foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportIm();
        $this->em->flush();
        $ims = $vcard->getIms();
        $this->assertCount(2, $ims);
        $this->assertInstanceOf('Heartsentwined\Vcard\Entity\Im', $ims[0]);
        $this->assertSame('foo', $ims[0]->getValue());
        $this->assertEmpty($ims[0]->getProtocol());
        $this->assertEquals(false, $ims[0]->getIsUri());
        $this->assertInstanceOf('Heartsentwined\Vcard\Entity\Im', $ims[1]);
        $this->assertSame('foo', $ims[1]->getValue());
        $this->assertSame($jabber, $ims[1]->getProtocol());
        $this->assertEquals(false, $ims[1]->getIsUri());
        $this->assertCount(4, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Im')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\ImProtocol')
            ->findAll());

        // detect protocol
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
IMPP:gtalk://foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportIm();
        $this->em->flush();
        $ims = $vcard->getIms();
        $this->assertCount(1, $ims);
        $this->assertInstanceOf('Heartsentwined\Vcard\Entity\Im', $ims[0]);
        $this->assertSame('gtalk://foo', $ims[0]->getValue());
        $this->assertSame($jabber, $ims[0]->getProtocol());
        $this->assertTrue($ims[0]->getIsUri());
        $this->assertCount(5, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Im')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\ImProtocol')
            ->findAll());

        // no protocol detection for non-standard properties, even on conflict
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
X-JABBER:msnim://foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportIm();
        $this->em->flush();
        $ims = $vcard->getIms();
        $this->assertCount(1, $ims);
        $this->assertInstanceOf('Heartsentwined\Vcard\Entity\Im', $ims[0]);
        $this->assertSame('msnim://foo', $ims[0]->getValue());
        $this->assertSame($jabber, $ims[0]->getProtocol());
        $this->assertEquals(false, $ims[0]->getIsUri());
        $this->assertCount(6, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Im')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\ImProtocol')
            ->findAll());

        // empty entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
IMPP:
X-JABBER:
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportIm();
        $this->em->flush();
        $ims = $vcard->getIms();
        $this->assertCount(0, $ims);
        $this->assertCount(6, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Im')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\ImProtocol')
            ->findAll());

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportIm();
        $this->em->flush();
        $ims = $vcard->getIms();
        $this->assertCount(0, $ims);
        $this->assertCount(6, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Im')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\ImProtocol')
            ->findAll());
         */
    }

    public function testExportLanguage()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
LANG:foo
LANG:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addLanguage'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addLanguage');

        $this->exporter->exportLanguage();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
LANG:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addLanguage'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addLanguage');

        $this->exporter->exportLanguage();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addLanguage'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addLanguage');

        $this->exporter->exportLanguage();
         */
    }

    public function testExportTimezone()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
TZ:foo
TZ:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addTimezone'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addTimezone');

        $this->exporter->exportTimezone();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
TZ:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addTimezone'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addTimezone');

        $this->exporter->exportTimezone();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addTimezone'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addTimezone');

        $this->exporter->exportTimezone();
         */
    }

    public function testExportGeo()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
GEO:foo
GEO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addGeo'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addGeo');

        $this->exporter->exportGeo();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
GEO:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addGeo'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addGeo');

        $this->exporter->exportGeo();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addGeo'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addGeo');

        $this->exporter->exportGeo();
         */
    }

    public function testExportTitle()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
TITLE:foo
TITLE:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addTitle'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addTitle');

        $this->exporter->exportTitle();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
TITLE:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addTitle'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addTitle');

        $this->exporter->exportTitle();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addTitle'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addTitle');

        $this->exporter->exportTitle();
         */
    }

    public function testExportRole()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
ROLE:foo
ROLE:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addRole'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addRole');

        $this->exporter->exportRole();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
ROLE:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addRole'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addRole');

        $this->exporter->exportRole();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addRole'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addRole');

        $this->exporter->exportRole();
         */
    }

    public function testExportLogo()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
LOGO:foo
LOGO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addLogo'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addLogo');

        $this->exporter->exportLogo();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
LOGO:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addLogo'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addLogo');

        $this->exporter->exportLogo();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addLogo'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addLogo');

        $this->exporter->exportLogo();
         */
    }

    public function testExportOrg()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
ORG:foo
ORG:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addOrg'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addOrg');

        $this->exporter->exportOrg();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
ORG:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addOrg'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addOrg');

        $this->exporter->exportOrg();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addOrg'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addOrg');

        $this->exporter->exportOrg();
         */
    }

    public function testExportMember()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
MEMBER:foo
MEMBER:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addMember'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addMember');

        $this->exporter->exportMember();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
MEMBER:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addMember'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addMember');

        $this->exporter->exportMember();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addMember'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addMember');

        $this->exporter->exportMember();
         */
    }

    public function testExportRelation()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
RELATED;TYPE=foo:foo
RELATED;TYPE=bar:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addRelation'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addRelation');

        $this->exporter->exportRelation();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
RELATED:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addRelation'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addRelation');

        $this->exporter->exportRelation();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addRelation'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addRelation');

        $this->exporter->exportRelation();
         */
    }

    public function testExportTag()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
CATEGORIES:foo
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportTag();
        $this->em->flush();
        $tags = $vcard->getTags();
        $this->assertCount(1, $tags);
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Tag', $tags[0]);
        $values = $tags[0]->getValues();
        $this->assertCount(1, $values);
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\TagValue', $values[0]);
        $this->assertSame('foo', $values[0]->getValue());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Tag')
            ->findAll());
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\TagValue')
            ->findAll());

        // comma-separated values
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
CATEGORIES:foo,bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportTag();
        $this->em->flush();
        $tags = $vcard->getTags();
        $this->assertCount(1, $tags);
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Tag', $tags[0]);
        $values = $tags[0]->getValues();
        $this->assertCount(2, $values);
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\TagValue', $values[0]);
        $this->assertSame('foo', $values[0]->getValue());
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\TagValue', $values[1]);
        $this->assertSame('bar', $values[1]->getValue());
        $this->assertCount(2, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Tag')
            ->findAll());
        $this->assertCount(2, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\TagValue')
            ->findAll());

        // multiple entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
CATEGORIES:foo
CATEGORIES:bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportTag();
        $this->em->flush();
        $tags = $vcard->getTags();
        $this->assertCount(2, $tags);
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Tag', $tags[0]);
        $values = $tags[0]->getValues();
        $this->assertCount(1, $values);
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\TagValue', $values[0]);
        $this->assertSame('foo', $values[0]->getValue());
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Tag', $tags[1]);
        $values = $tags[1]->getValues();
        $this->assertCount(1, $values);
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\TagValue', $values[0]);
        $this->assertSame('bar', $values[0]->getValue());
        $this->assertCount(4, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Tag')
            ->findAll());
        $this->assertCount(2, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\TagValue')
            ->findAll());

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
CATEGORIES:
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportTag();
        $this->em->flush();
        $tags = $vcard->getTags();
        $this->assertCount(0, $tags);
        $this->assertCount(4, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Tag')
            ->findAll());
        $this->assertCount(2, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\TagValue')
            ->findAll());

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );
        $vcard = new Entity\Vcard;
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard)
            ->exportTag();
        $this->em->flush();
        $tags = $vcard->getTags();
        $this->assertCount(0, $tags);
        $this->assertCount(4, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Tag')
            ->findAll());
        $this->assertCount(2, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\TagValue')
            ->findAll());
         */
    }

    public function testExportNote()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
NOTE:foo
NOTE:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addNote'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addNote');

        $this->exporter->exportNote();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
NOTE:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addNote'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addNote');

        $this->exporter->exportNote();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addNote'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addNote');

        $this->exporter->exportNote();
         */
    }

    public function testExportSound()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
SOUND:foo
SOUND:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addSound'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addSound');

        $this->exporter->exportSound();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
SOUND:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addSound'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addSound');

        $this->exporter->exportSound();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addSound'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addSound');

        $this->exporter->exportSound();
         */
    }

    public function testExportUid()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
UID:foo
UID:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('setUid'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->once())
            ->method('setUid');

        $this->exporter->exportUid();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
UID:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('setUid'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('setUid');

        $this->exporter->exportUid();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('setUid'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('setUid');

        $this->exporter->exportUid();
         */
    }

    public function testExportUrl()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
URL:foo
URL:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addUrl'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addUrl');

        $this->exporter->exportUrl();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
URL:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addUrl'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addUrl');

        $this->exporter->exportUrl();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addUrl'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addUrl');

        $this->exporter->exportUrl();
         */
    }

    public function testExportPublicKey()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
KEY:foo
KEY:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addPublicKey'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addPublicKey');

        $this->exporter->exportPublicKey();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
KEY:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addPublicKey'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addPublicKey');

        $this->exporter->exportPublicKey();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addPublicKey'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addPublicKey');

        $this->exporter->exportPublicKey();
         */
    }

    public function testExportFreebusy()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FBURL:foo
FBURL:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addFreebusy'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addFreebusy');

        $this->exporter->exportFreebusy();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FBURL:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addFreebusy'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addFreebusy');

        $this->exporter->exportFreebusy();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addFreebusy'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addFreebusy');

        $this->exporter->exportFreebusy();
         */
    }

    public function testExportCalendar()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
CALURI:foo
CALURI:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addCalendar'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addCalendar');

        $this->exporter->exportCalendar();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
CALURI:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addCalendar'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addCalendar');

        $this->exporter->exportCalendar();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addCalendar'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addCalendar');

        $this->exporter->exportCalendar();
         */
    }

    public function testExportCalendarRequest()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        // standard entries
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
CALADRURI:foo
CALADRURI:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addCalendarRequest'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addCalendarRequest');

        $this->exporter->exportCalendarRequest();

        // empty entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
CALADRURI:
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addCalendarRequest'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addCalendarRequest');

        $this->exporter->exportCalendarRequest();

        // no entry
        $card = $this->exporter->parseSource(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addCalendarRequest'));
        $this->exporter
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->never())
            ->method('addCalendarRequest');

        $this->exporter->exportCalendarRequest();
         */
    }

    public function testExport()
    {
        $this->fail('not yet implemented');
        // skeleton from importer
        /*
        $this->assertInstanceOf(
            'Heartsentwined\Vcard\Entity\Vcard',
            $this->exporter->export(<<<STR
BEGIN:VCARD
FOO:bar
END:VCARD
STR
        ));
         */
    }
}
