<?php
namespace Heartsentwined\Vcard\Test\Service;

use Heartsentwined\Vcard\Entity;
use Heartsentwined\Vcard\Service\Importer;
use Heartsentwined\Phpunit\Testcase\Doctrine as DoctrineTestcase;

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
            ->setReader($this->sm->get('Sabre\VObject\Reader'));
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
            $card->ORG, 'Heartsentwined\Vcard\Entity\Org');
        $this->em->flush();
        $this->assertCount(2, $orgs);
        $this->assertCount(2, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Org')->findAll());

        $foo = $orgs[0];
        $bar = $orgs[1];

        $this->assertSame('foo', $foo->getValue());
        $this->assertSame('bar', $bar->getValue());
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
            $card->ORG, 'Heartsentwined\Vcard\Entity\Org');
        $this->em->flush();
        $this->assertInstanceOf('Heartsentwined\Vcard\Entity\Org', $foo);
        $this->assertCount(1, $this->em
            ->getRepository('Heartsentwined\Vcard\Entity\Org')->findAll());

        $this->assertSame('foo', $foo->getValue());
    }

    /**
     * @depends testParseSource
     */
    public function testImportSource()
    {
        $card = $this->importer->parseSource(<<<STR
BEGIN:VCARD
SOURCE:foo
SOURCE:bar
END:VCARD
STR
        );

        $vcard = $this->getMock(
            'Heartsentwined\Vcard\Entity\Vcard', array('addSource'));
        $this->importer
            ->setCard($card)
            ->setVcard($vcard);

        $vcard
            ->expects($this->exactly(2))
            ->method('addSource');

        $this->importer->importSource();
    }
}
