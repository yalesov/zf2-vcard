<?php

namespace Heartsentwined\Vcard\Entity;

/**
 * Heartsentwined\Vcard\Entity\Vcard
 */
class Vcard
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var Heartsentwined\Vcard\Entity\Gender
     */
    private $gender;

    /**
     * @var Heartsentwined\Vcard\Entity\Uid
     */
    private $uid;

    /**
     * @var Heartsentwined\Vcard\Entity\Birthday
     */
    private $birthday;

    /**
     * @var Heartsentwined\Vcard\Entity\Anniversary
     */
    private $anniversary;

    /**
     * @var Heartsentwined\Vcard\Entity\Kind
     */
    private $kind;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $sources;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $formattedNames;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $names;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $nicknames;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $photos;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $addresses;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $phones;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $emails;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $ims;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $urls;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $languages;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $timezones;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $geos;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $titles;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $roles;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $logos;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $orgs;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $members;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $relations;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $tags;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $notes;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $sounds;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $publicKeys;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $freebusies;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $calendars;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $calendarRequests;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formattedNames = new \Doctrine\Common\Collections\ArrayCollection();
        $this->names = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nicknames = new \Doctrine\Common\Collections\ArrayCollection();
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->phones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ims = new \Doctrine\Common\Collections\ArrayCollection();
        $this->urls = new \Doctrine\Common\Collections\ArrayCollection();
        $this->languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timezones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->geos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->titles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->logos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orgs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
        $this->relations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->notes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sounds = new \Doctrine\Common\Collections\ArrayCollection();
        $this->publicKeys = new \Doctrine\Common\Collections\ArrayCollection();
        $this->freebusies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->calendars = new \Doctrine\Common\Collections\ArrayCollection();
        $this->calendarRequests = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set gender
     *
     * @param  Heartsentwined\Vcard\Entity\Gender $gender
     * @return Vcard
     */
    public function setGender(\Heartsentwined\Vcard\Entity\Gender $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return Heartsentwined\Vcard\Entity\Gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set uid
     *
     * @param  Heartsentwined\Vcard\Entity\Uid $uid
     * @return Vcard
     */
    public function setUid(\Heartsentwined\Vcard\Entity\Uid $uid = null)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return Heartsentwined\Vcard\Entity\Uid
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set birthday
     *
     * @param  Heartsentwined\Vcard\Entity\Birthday $birthday
     * @return Vcard
     */
    public function setBirthday(\Heartsentwined\Vcard\Entity\Birthday $birthday = null)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return Heartsentwined\Vcard\Entity\Birthday
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set anniversary
     *
     * @param  Heartsentwined\Vcard\Entity\Anniversary $anniversary
     * @return Vcard
     */
    public function setAnniversary(\Heartsentwined\Vcard\Entity\Anniversary $anniversary = null)
    {
        $this->anniversary = $anniversary;

        return $this;
    }

    /**
     * Get anniversary
     *
     * @return Heartsentwined\Vcard\Entity\Anniversary
     */
    public function getAnniversary()
    {
        return $this->anniversary;
    }

    /**
     * Set kind
     *
     * @param  Heartsentwined\Vcard\Entity\Kind $kind
     * @return Vcard
     */
    public function setKind(\Heartsentwined\Vcard\Entity\Kind $kind = null)
    {
        $this->kind = $kind;

        return $this;
    }

    /**
     * Get kind
     *
     * @return Heartsentwined\Vcard\Entity\Kind
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * Add sources
     *
     * @param  Heartsentwined\Vcard\Entity\Source $sources
     * @return Vcard
     */
    public function addSource(\Heartsentwined\Vcard\Entity\Source $sources)
    {
        $this->sources[] = $sources;

        return $this;
    }

    /**
     * Remove sources
     *
     * @param Heartsentwined\Vcard\Entity\Source $sources
     */
    public function removeSource(\Heartsentwined\Vcard\Entity\Source $sources)
    {
        $this->sources->removeElement($sources);
    }

    /**
     * Get sources
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * Add formattedNames
     *
     * @param  Heartsentwined\Vcard\Entity\FormattedName $formattedNames
     * @return Vcard
     */
    public function addFormattedName(\Heartsentwined\Vcard\Entity\FormattedName $formattedNames)
    {
        $this->formattedNames[] = $formattedNames;

        return $this;
    }

    /**
     * Remove formattedNames
     *
     * @param Heartsentwined\Vcard\Entity\FormattedName $formattedNames
     */
    public function removeFormattedName(\Heartsentwined\Vcard\Entity\FormattedName $formattedNames)
    {
        $this->formattedNames->removeElement($formattedNames);
    }

    /**
     * Get formattedNames
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getFormattedNames()
    {
        return $this->formattedNames;
    }

    /**
     * Add names
     *
     * @param  Heartsentwined\Vcard\Entity\Name $names
     * @return Vcard
     */
    public function addName(\Heartsentwined\Vcard\Entity\Name $names)
    {
        $this->names[] = $names;

        return $this;
    }

    /**
     * Remove names
     *
     * @param Heartsentwined\Vcard\Entity\Name $names
     */
    public function removeName(\Heartsentwined\Vcard\Entity\Name $names)
    {
        $this->names->removeElement($names);
    }

    /**
     * Get names
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * Add nicknames
     *
     * @param  Heartsentwined\Vcard\Entity\Nickname $nicknames
     * @return Vcard
     */
    public function addNickname(\Heartsentwined\Vcard\Entity\Nickname $nicknames)
    {
        $this->nicknames[] = $nicknames;

        return $this;
    }

    /**
     * Remove nicknames
     *
     * @param Heartsentwined\Vcard\Entity\Nickname $nicknames
     */
    public function removeNickname(\Heartsentwined\Vcard\Entity\Nickname $nicknames)
    {
        $this->nicknames->removeElement($nicknames);
    }

    /**
     * Get nicknames
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getNicknames()
    {
        return $this->nicknames;
    }

    /**
     * Add photos
     *
     * @param  Heartsentwined\Vcard\Entity\Photo $photos
     * @return Vcard
     */
    public function addPhoto(\Heartsentwined\Vcard\Entity\Photo $photos)
    {
        $this->photos[] = $photos;

        return $this;
    }

    /**
     * Remove photos
     *
     * @param Heartsentwined\Vcard\Entity\Photo $photos
     */
    public function removePhoto(\Heartsentwined\Vcard\Entity\Photo $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * Get photos
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Add addresses
     *
     * @param  Heartsentwined\Vcard\Entity\Address $addresses
     * @return Vcard
     */
    public function addAddress(\Heartsentwined\Vcard\Entity\Address $addresses)
    {
        $this->addresses[] = $addresses;

        return $this;
    }

    /**
     * Remove addresses
     *
     * @param Heartsentwined\Vcard\Entity\Address $addresses
     */
    public function removeAddress(\Heartsentwined\Vcard\Entity\Address $addresses)
    {
        $this->addresses->removeElement($addresses);
    }

    /**
     * Get addresses
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add phones
     *
     * @param  Heartsentwined\Vcard\Entity\Phone $phones
     * @return Vcard
     */
    public function addPhone(\Heartsentwined\Vcard\Entity\Phone $phones)
    {
        $this->phones[] = $phones;

        return $this;
    }

    /**
     * Remove phones
     *
     * @param Heartsentwined\Vcard\Entity\Phone $phones
     */
    public function removePhone(\Heartsentwined\Vcard\Entity\Phone $phones)
    {
        $this->phones->removeElement($phones);
    }

    /**
     * Get phones
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Add emails
     *
     * @param  Heartsentwined\Vcard\Entity\Email $emails
     * @return Vcard
     */
    public function addEmail(\Heartsentwined\Vcard\Entity\Email $emails)
    {
        $this->emails[] = $emails;

        return $this;
    }

    /**
     * Remove emails
     *
     * @param Heartsentwined\Vcard\Entity\Email $emails
     */
    public function removeEmail(\Heartsentwined\Vcard\Entity\Email $emails)
    {
        $this->emails->removeElement($emails);
    }

    /**
     * Get emails
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add ims
     *
     * @param  Heartsentwined\Vcard\Entity\Im $ims
     * @return Vcard
     */
    public function addIm(\Heartsentwined\Vcard\Entity\Im $ims)
    {
        $this->ims[] = $ims;

        return $this;
    }

    /**
     * Remove ims
     *
     * @param Heartsentwined\Vcard\Entity\Im $ims
     */
    public function removeIm(\Heartsentwined\Vcard\Entity\Im $ims)
    {
        $this->ims->removeElement($ims);
    }

    /**
     * Get ims
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getIms()
    {
        return $this->ims;
    }

    /**
     * Add urls
     *
     * @param  Heartsentwined\Vcard\Entity\Url $urls
     * @return Vcard
     */
    public function addUrl(\Heartsentwined\Vcard\Entity\Url $urls)
    {
        $this->urls[] = $urls;

        return $this;
    }

    /**
     * Remove urls
     *
     * @param Heartsentwined\Vcard\Entity\Url $urls
     */
    public function removeUrl(\Heartsentwined\Vcard\Entity\Url $urls)
    {
        $this->urls->removeElement($urls);
    }

    /**
     * Get urls
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * Add languages
     *
     * @param  Heartsentwined\Vcard\Entity\Language $languages
     * @return Vcard
     */
    public function addLanguage(\Heartsentwined\Vcard\Entity\Language $languages)
    {
        $this->languages[] = $languages;

        return $this;
    }

    /**
     * Remove languages
     *
     * @param Heartsentwined\Vcard\Entity\Language $languages
     */
    public function removeLanguage(\Heartsentwined\Vcard\Entity\Language $languages)
    {
        $this->languages->removeElement($languages);
    }

    /**
     * Get languages
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Add timezones
     *
     * @param  Heartsentwined\Vcard\Entity\Timezone $timezones
     * @return Vcard
     */
    public function addTimezone(\Heartsentwined\Vcard\Entity\Timezone $timezones)
    {
        $this->timezones[] = $timezones;

        return $this;
    }

    /**
     * Remove timezones
     *
     * @param Heartsentwined\Vcard\Entity\Timezone $timezones
     */
    public function removeTimezone(\Heartsentwined\Vcard\Entity\Timezone $timezones)
    {
        $this->timezones->removeElement($timezones);
    }

    /**
     * Get timezones
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getTimezones()
    {
        return $this->timezones;
    }

    /**
     * Add geos
     *
     * @param  Heartsentwined\Vcard\Entity\Geo $geos
     * @return Vcard
     */
    public function addGeo(\Heartsentwined\Vcard\Entity\Geo $geos)
    {
        $this->geos[] = $geos;

        return $this;
    }

    /**
     * Remove geos
     *
     * @param Heartsentwined\Vcard\Entity\Geo $geos
     */
    public function removeGeo(\Heartsentwined\Vcard\Entity\Geo $geos)
    {
        $this->geos->removeElement($geos);
    }

    /**
     * Get geos
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getGeos()
    {
        return $this->geos;
    }

    /**
     * Add titles
     *
     * @param  Heartsentwined\Vcard\Entity\Title $titles
     * @return Vcard
     */
    public function addTitle(\Heartsentwined\Vcard\Entity\Title $titles)
    {
        $this->titles[] = $titles;

        return $this;
    }

    /**
     * Remove titles
     *
     * @param Heartsentwined\Vcard\Entity\Title $titles
     */
    public function removeTitle(\Heartsentwined\Vcard\Entity\Title $titles)
    {
        $this->titles->removeElement($titles);
    }

    /**
     * Get titles
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getTitles()
    {
        return $this->titles;
    }

    /**
     * Add roles
     *
     * @param  Heartsentwined\Vcard\Entity\Role $roles
     * @return Vcard
     */
    public function addRole(\Heartsentwined\Vcard\Entity\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param Heartsentwined\Vcard\Entity\Role $roles
     */
    public function removeRole(\Heartsentwined\Vcard\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Add logos
     *
     * @param  Heartsentwined\Vcard\Entity\Logo $logos
     * @return Vcard
     */
    public function addLogo(\Heartsentwined\Vcard\Entity\Logo $logos)
    {
        $this->logos[] = $logos;

        return $this;
    }

    /**
     * Remove logos
     *
     * @param Heartsentwined\Vcard\Entity\Logo $logos
     */
    public function removeLogo(\Heartsentwined\Vcard\Entity\Logo $logos)
    {
        $this->logos->removeElement($logos);
    }

    /**
     * Get logos
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getLogos()
    {
        return $this->logos;
    }

    /**
     * Add orgs
     *
     * @param  Heartsentwined\Vcard\Entity\Org $orgs
     * @return Vcard
     */
    public function addOrg(\Heartsentwined\Vcard\Entity\Org $orgs)
    {
        $this->orgs[] = $orgs;

        return $this;
    }

    /**
     * Remove orgs
     *
     * @param Heartsentwined\Vcard\Entity\Org $orgs
     */
    public function removeOrg(\Heartsentwined\Vcard\Entity\Org $orgs)
    {
        $this->orgs->removeElement($orgs);
    }

    /**
     * Get orgs
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getOrgs()
    {
        return $this->orgs;
    }

    /**
     * Add members
     *
     * @param  Heartsentwined\Vcard\Entity\Member $members
     * @return Vcard
     */
    public function addMember(\Heartsentwined\Vcard\Entity\Member $members)
    {
        $this->members[] = $members;

        return $this;
    }

    /**
     * Remove members
     *
     * @param Heartsentwined\Vcard\Entity\Member $members
     */
    public function removeMember(\Heartsentwined\Vcard\Entity\Member $members)
    {
        $this->members->removeElement($members);
    }

    /**
     * Get members
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Add relations
     *
     * @param  Heartsentwined\Vcard\Entity\Relation $relations
     * @return Vcard
     */
    public function addRelation(\Heartsentwined\Vcard\Entity\Relation $relations)
    {
        $this->relations[] = $relations;

        return $this;
    }

    /**
     * Remove relations
     *
     * @param Heartsentwined\Vcard\Entity\Relation $relations
     */
    public function removeRelation(\Heartsentwined\Vcard\Entity\Relation $relations)
    {
        $this->relations->removeElement($relations);
    }

    /**
     * Get relations
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * Add tags
     *
     * @param  Heartsentwined\Vcard\Entity\Tag $tags
     * @return Vcard
     */
    public function addTag(\Heartsentwined\Vcard\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param Heartsentwined\Vcard\Entity\Tag $tags
     */
    public function removeTag(\Heartsentwined\Vcard\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add notes
     *
     * @param  Heartsentwined\Vcard\Entity\Note $notes
     * @return Vcard
     */
    public function addNote(\Heartsentwined\Vcard\Entity\Note $notes)
    {
        $this->notes[] = $notes;

        return $this;
    }

    /**
     * Remove notes
     *
     * @param Heartsentwined\Vcard\Entity\Note $notes
     */
    public function removeNote(\Heartsentwined\Vcard\Entity\Note $notes)
    {
        $this->notes->removeElement($notes);
    }

    /**
     * Get notes
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Add sounds
     *
     * @param  Heartsentwined\Vcard\Entity\Sound $sounds
     * @return Vcard
     */
    public function addSound(\Heartsentwined\Vcard\Entity\Sound $sounds)
    {
        $this->sounds[] = $sounds;

        return $this;
    }

    /**
     * Remove sounds
     *
     * @param Heartsentwined\Vcard\Entity\Sound $sounds
     */
    public function removeSound(\Heartsentwined\Vcard\Entity\Sound $sounds)
    {
        $this->sounds->removeElement($sounds);
    }

    /**
     * Get sounds
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSounds()
    {
        return $this->sounds;
    }

    /**
     * Add publicKeys
     *
     * @param  Heartsentwined\Vcard\Entity\PublicKey $publicKeys
     * @return Vcard
     */
    public function addPublicKey(\Heartsentwined\Vcard\Entity\PublicKey $publicKeys)
    {
        $this->publicKeys[] = $publicKeys;

        return $this;
    }

    /**
     * Remove publicKeys
     *
     * @param Heartsentwined\Vcard\Entity\PublicKey $publicKeys
     */
    public function removePublicKey(\Heartsentwined\Vcard\Entity\PublicKey $publicKeys)
    {
        $this->publicKeys->removeElement($publicKeys);
    }

    /**
     * Get publicKeys
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getPublicKeys()
    {
        return $this->publicKeys;
    }

    /**
     * Add freebusies
     *
     * @param  Heartsentwined\Vcard\Entity\Freebusy $freebusies
     * @return Vcard
     */
    public function addFreebusie(\Heartsentwined\Vcard\Entity\Freebusy $freebusies)
    {
        $this->freebusies[] = $freebusies;

        return $this;
    }

    /**
     * Remove freebusies
     *
     * @param Heartsentwined\Vcard\Entity\Freebusy $freebusies
     */
    public function removeFreebusie(\Heartsentwined\Vcard\Entity\Freebusy $freebusies)
    {
        $this->freebusies->removeElement($freebusies);
    }

    /**
     * Get freebusies
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getFreebusies()
    {
        return $this->freebusies;
    }

    /**
     * Add calendars
     *
     * @param  Heartsentwined\Vcard\Entity\Calendar $calendars
     * @return Vcard
     */
    public function addCalendar(\Heartsentwined\Vcard\Entity\Calendar $calendars)
    {
        $this->calendars[] = $calendars;

        return $this;
    }

    /**
     * Remove calendars
     *
     * @param Heartsentwined\Vcard\Entity\Calendar $calendars
     */
    public function removeCalendar(\Heartsentwined\Vcard\Entity\Calendar $calendars)
    {
        $this->calendars->removeElement($calendars);
    }

    /**
     * Get calendars
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getCalendars()
    {
        return $this->calendars;
    }

    /**
     * Add calendarRequests
     *
     * @param  Heartsentwined\Vcard\Entity\CalendarRequest $calendarRequests
     * @return Vcard
     */
    public function addCalendarRequest(\Heartsentwined\Vcard\Entity\CalendarRequest $calendarRequests)
    {
        $this->calendarRequests[] = $calendarRequests;

        return $this;
    }

    /**
     * Remove calendarRequests
     *
     * @param Heartsentwined\Vcard\Entity\CalendarRequest $calendarRequests
     */
    public function removeCalendarRequest(\Heartsentwined\Vcard\Entity\CalendarRequest $calendarRequests)
    {
        $this->calendarRequests->removeElement($calendarRequests);
    }

    /**
     * Get calendarRequests
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getCalendarRequests()
    {
        return $this->calendarRequests;
    }
}
