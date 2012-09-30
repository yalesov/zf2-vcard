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

    public function testNormalize()
    {
        $this->assertSame('', $this->importer->normalize(''));
        $this->assertSame("BEGIN:\né",
            $this->importer->normalize("BEGIN:\n<u+00e9>"));
        $this->assertSame(<<<STR
BEGIN:VCARD
 foo
STR
            , $this->importer->normalize(<<<STR
BEGIN:VCARD
        foo
STR
        ));
    }

    public function testParse()
    {
        $this->assertInstanceOf(
            'Sabre\VObject\Node',
            $this->importer->parse(<<<STR
BEGIN:VCARD
VERSION:4.0
END:VCARD
STR
            ));
    }

    public function testParam()
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

        $card = $this->importer->parse(<<<STR
BEGIN:VCARD
VERSION:4.0
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

        $param = $this->importer->param($card->ALL);
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

        $param = $this->importer->param($card->ALLEMPTY);
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

        $param = $this->importer->param($card->{'VALUE-OLD'});
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

        $param = $this->importer->param($card->{'VALUE-NEW'});
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

        $param = $this->importer->param($card->{'VALUE-EMPTY'});
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

        $param = $this->importer->param($card->{'TYPE-COMMA'});
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

        $param = $this->importer->param($card->{'TYPE-NEW'});
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

        $param = $this->importer->param($card->{'TYPE-EMPTY'});
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
}
