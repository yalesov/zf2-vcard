<?php

namespace Yalesov\Vcard\Entity;

/**
 * Yalesov\Vcard\Entity\Vcard
 */
class Vcard
{
  /**
   * @var integer $id
   */
  private $id;

  /**
   * @var Yalesov\Vcard\Entity\Gender
   */
  private $gender;

  /**
   * @var Yalesov\Vcard\Entity\Uid
   */
  private $uid;

  /**
   * @var Yalesov\Vcard\Entity\Birthday
   */
  private $birthday;

  /**
   * @var Yalesov\Vcard\Entity\Anniversary
   */
  private $anniversary;

  /**
   * @var Yalesov\Vcard\Entity\Kind
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
   * @param  Yalesov\Vcard\Entity\Gender $gender
   * @return Vcard
   */
  public function setGender(\Yalesov\Vcard\Entity\Gender $gender = null)
  {
    $this->gender = $gender;

    return $this;
  }

  /**
   * Get gender
   *
   * @return Yalesov\Vcard\Entity\Gender
   */
  public function getGender()
  {
    return $this->gender;
  }

  /**
   * Set uid
   *
   * @param  Yalesov\Vcard\Entity\Uid $uid
   * @return Vcard
   */
  public function setUid(\Yalesov\Vcard\Entity\Uid $uid = null)
  {
    $this->uid = $uid;

    return $this;
  }

  /**
   * Get uid
   *
   * @return Yalesov\Vcard\Entity\Uid
   */
  public function getUid()
  {
    return $this->uid;
  }

  /**
   * Set birthday
   *
   * @param  Yalesov\Vcard\Entity\Birthday $birthday
   * @return Vcard
   */
  public function setBirthday(\Yalesov\Vcard\Entity\Birthday $birthday = null)
  {
    $this->birthday = $birthday;

    return $this;
  }

  /**
   * Get birthday
   *
   * @return Yalesov\Vcard\Entity\Birthday
   */
  public function getBirthday()
  {
    return $this->birthday;
  }

  /**
   * Set anniversary
   *
   * @param  Yalesov\Vcard\Entity\Anniversary $anniversary
   * @return Vcard
   */
  public function setAnniversary(\Yalesov\Vcard\Entity\Anniversary $anniversary = null)
  {
    $this->anniversary = $anniversary;

    return $this;
  }

  /**
   * Get anniversary
   *
   * @return Yalesov\Vcard\Entity\Anniversary
   */
  public function getAnniversary()
  {
    return $this->anniversary;
  }

  /**
   * Set kind
   *
   * @param  Yalesov\Vcard\Entity\Kind $kind
   * @return Vcard
   */
  public function setKind(\Yalesov\Vcard\Entity\Kind $kind = null)
  {
    $this->kind = $kind;

    return $this;
  }

  /**
   * Get kind
   *
   * @return Yalesov\Vcard\Entity\Kind
   */
  public function getKind()
  {
    return $this->kind;
  }

  /**
   * Add sources
   *
   * @param  Yalesov\Vcard\Entity\Source $sources
   * @return Vcard
   */
  public function addSource(\Yalesov\Vcard\Entity\Source $sources)
  {
    $this->sources[] = $sources;

    return $this;
  }

  /**
   * Remove sources
   *
   * @param Yalesov\Vcard\Entity\Source $sources
   */
  public function removeSource(\Yalesov\Vcard\Entity\Source $sources)
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
   * @param  Yalesov\Vcard\Entity\FormattedName $formattedNames
   * @return Vcard
   */
  public function addFormattedName(\Yalesov\Vcard\Entity\FormattedName $formattedNames)
  {
    $this->formattedNames[] = $formattedNames;

    return $this;
  }

  /**
   * Remove formattedNames
   *
   * @param Yalesov\Vcard\Entity\FormattedName $formattedNames
   */
  public function removeFormattedName(\Yalesov\Vcard\Entity\FormattedName $formattedNames)
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
   * @param  Yalesov\Vcard\Entity\Name $names
   * @return Vcard
   */
  public function addName(\Yalesov\Vcard\Entity\Name $names)
  {
    $this->names[] = $names;

    return $this;
  }

  /**
   * Remove names
   *
   * @param Yalesov\Vcard\Entity\Name $names
   */
  public function removeName(\Yalesov\Vcard\Entity\Name $names)
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
   * @param  Yalesov\Vcard\Entity\Nickname $nicknames
   * @return Vcard
   */
  public function addNickname(\Yalesov\Vcard\Entity\Nickname $nicknames)
  {
    $this->nicknames[] = $nicknames;

    return $this;
  }

  /**
   * Remove nicknames
   *
   * @param Yalesov\Vcard\Entity\Nickname $nicknames
   */
  public function removeNickname(\Yalesov\Vcard\Entity\Nickname $nicknames)
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
   * @param  Yalesov\Vcard\Entity\Photo $photos
   * @return Vcard
   */
  public function addPhoto(\Yalesov\Vcard\Entity\Photo $photos)
  {
    $this->photos[] = $photos;

    return $this;
  }

  /**
   * Remove photos
   *
   * @param Yalesov\Vcard\Entity\Photo $photos
   */
  public function removePhoto(\Yalesov\Vcard\Entity\Photo $photos)
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
   * @param  Yalesov\Vcard\Entity\Address $addresses
   * @return Vcard
   */
  public function addAddress(\Yalesov\Vcard\Entity\Address $addresses)
  {
    $this->addresses[] = $addresses;

    return $this;
  }

  /**
   * Remove addresses
   *
   * @param Yalesov\Vcard\Entity\Address $addresses
   */
  public function removeAddress(\Yalesov\Vcard\Entity\Address $addresses)
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
   * @param  Yalesov\Vcard\Entity\Phone $phones
   * @return Vcard
   */
  public function addPhone(\Yalesov\Vcard\Entity\Phone $phones)
  {
    $this->phones[] = $phones;

    return $this;
  }

  /**
   * Remove phones
   *
   * @param Yalesov\Vcard\Entity\Phone $phones
   */
  public function removePhone(\Yalesov\Vcard\Entity\Phone $phones)
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
   * @param  Yalesov\Vcard\Entity\Email $emails
   * @return Vcard
   */
  public function addEmail(\Yalesov\Vcard\Entity\Email $emails)
  {
    $this->emails[] = $emails;

    return $this;
  }

  /**
   * Remove emails
   *
   * @param Yalesov\Vcard\Entity\Email $emails
   */
  public function removeEmail(\Yalesov\Vcard\Entity\Email $emails)
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
   * @param  Yalesov\Vcard\Entity\Im $ims
   * @return Vcard
   */
  public function addIm(\Yalesov\Vcard\Entity\Im $ims)
  {
    $this->ims[] = $ims;

    return $this;
  }

  /**
   * Remove ims
   *
   * @param Yalesov\Vcard\Entity\Im $ims
   */
  public function removeIm(\Yalesov\Vcard\Entity\Im $ims)
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
   * @param  Yalesov\Vcard\Entity\Url $urls
   * @return Vcard
   */
  public function addUrl(\Yalesov\Vcard\Entity\Url $urls)
  {
    $this->urls[] = $urls;

    return $this;
  }

  /**
   * Remove urls
   *
   * @param Yalesov\Vcard\Entity\Url $urls
   */
  public function removeUrl(\Yalesov\Vcard\Entity\Url $urls)
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
   * @param  Yalesov\Vcard\Entity\Language $languages
   * @return Vcard
   */
  public function addLanguage(\Yalesov\Vcard\Entity\Language $languages)
  {
    $this->languages[] = $languages;

    return $this;
  }

  /**
   * Remove languages
   *
   * @param Yalesov\Vcard\Entity\Language $languages
   */
  public function removeLanguage(\Yalesov\Vcard\Entity\Language $languages)
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
   * @param  Yalesov\Vcard\Entity\Timezone $timezones
   * @return Vcard
   */
  public function addTimezone(\Yalesov\Vcard\Entity\Timezone $timezones)
  {
    $this->timezones[] = $timezones;

    return $this;
  }

  /**
   * Remove timezones
   *
   * @param Yalesov\Vcard\Entity\Timezone $timezones
   */
  public function removeTimezone(\Yalesov\Vcard\Entity\Timezone $timezones)
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
   * @param  Yalesov\Vcard\Entity\Geo $geos
   * @return Vcard
   */
  public function addGeo(\Yalesov\Vcard\Entity\Geo $geos)
  {
    $this->geos[] = $geos;

    return $this;
  }

  /**
   * Remove geos
   *
   * @param Yalesov\Vcard\Entity\Geo $geos
   */
  public function removeGeo(\Yalesov\Vcard\Entity\Geo $geos)
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
   * @param  Yalesov\Vcard\Entity\Title $titles
   * @return Vcard
   */
  public function addTitle(\Yalesov\Vcard\Entity\Title $titles)
  {
    $this->titles[] = $titles;

    return $this;
  }

  /**
   * Remove titles
   *
   * @param Yalesov\Vcard\Entity\Title $titles
   */
  public function removeTitle(\Yalesov\Vcard\Entity\Title $titles)
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
   * @param  Yalesov\Vcard\Entity\Role $roles
   * @return Vcard
   */
  public function addRole(\Yalesov\Vcard\Entity\Role $roles)
  {
    $this->roles[] = $roles;

    return $this;
  }

  /**
   * Remove roles
   *
   * @param Yalesov\Vcard\Entity\Role $roles
   */
  public function removeRole(\Yalesov\Vcard\Entity\Role $roles)
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
   * @param  Yalesov\Vcard\Entity\Logo $logos
   * @return Vcard
   */
  public function addLogo(\Yalesov\Vcard\Entity\Logo $logos)
  {
    $this->logos[] = $logos;

    return $this;
  }

  /**
   * Remove logos
   *
   * @param Yalesov\Vcard\Entity\Logo $logos
   */
  public function removeLogo(\Yalesov\Vcard\Entity\Logo $logos)
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
   * @param  Yalesov\Vcard\Entity\Org $orgs
   * @return Vcard
   */
  public function addOrg(\Yalesov\Vcard\Entity\Org $orgs)
  {
    $this->orgs[] = $orgs;

    return $this;
  }

  /**
   * Remove orgs
   *
   * @param Yalesov\Vcard\Entity\Org $orgs
   */
  public function removeOrg(\Yalesov\Vcard\Entity\Org $orgs)
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
   * @param  Yalesov\Vcard\Entity\Member $members
   * @return Vcard
   */
  public function addMember(\Yalesov\Vcard\Entity\Member $members)
  {
    $this->members[] = $members;

    return $this;
  }

  /**
   * Remove members
   *
   * @param Yalesov\Vcard\Entity\Member $members
   */
  public function removeMember(\Yalesov\Vcard\Entity\Member $members)
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
   * @param  Yalesov\Vcard\Entity\Relation $relations
   * @return Vcard
   */
  public function addRelation(\Yalesov\Vcard\Entity\Relation $relations)
  {
    $this->relations[] = $relations;

    return $this;
  }

  /**
   * Remove relations
   *
   * @param Yalesov\Vcard\Entity\Relation $relations
   */
  public function removeRelation(\Yalesov\Vcard\Entity\Relation $relations)
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
   * @param  Yalesov\Vcard\Entity\Tag $tags
   * @return Vcard
   */
  public function addTag(\Yalesov\Vcard\Entity\Tag $tags)
  {
    $this->tags[] = $tags;

    return $this;
  }

  /**
   * Remove tags
   *
   * @param Yalesov\Vcard\Entity\Tag $tags
   */
  public function removeTag(\Yalesov\Vcard\Entity\Tag $tags)
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
   * @param  Yalesov\Vcard\Entity\Note $notes
   * @return Vcard
   */
  public function addNote(\Yalesov\Vcard\Entity\Note $notes)
  {
    $this->notes[] = $notes;

    return $this;
  }

  /**
   * Remove notes
   *
   * @param Yalesov\Vcard\Entity\Note $notes
   */
  public function removeNote(\Yalesov\Vcard\Entity\Note $notes)
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
   * @param  Yalesov\Vcard\Entity\Sound $sounds
   * @return Vcard
   */
  public function addSound(\Yalesov\Vcard\Entity\Sound $sounds)
  {
    $this->sounds[] = $sounds;

    return $this;
  }

  /**
   * Remove sounds
   *
   * @param Yalesov\Vcard\Entity\Sound $sounds
   */
  public function removeSound(\Yalesov\Vcard\Entity\Sound $sounds)
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
   * @param  Yalesov\Vcard\Entity\PublicKey $publicKeys
   * @return Vcard
   */
  public function addPublicKey(\Yalesov\Vcard\Entity\PublicKey $publicKeys)
  {
    $this->publicKeys[] = $publicKeys;

    return $this;
  }

  /**
   * Remove publicKeys
   *
   * @param Yalesov\Vcard\Entity\PublicKey $publicKeys
   */
  public function removePublicKey(\Yalesov\Vcard\Entity\PublicKey $publicKeys)
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
   * @param  Yalesov\Vcard\Entity\Freebusy $freebusies
   * @return Vcard
   */
  public function addFreebusie(\Yalesov\Vcard\Entity\Freebusy $freebusies)
  {
    $this->freebusies[] = $freebusies;

    return $this;
  }

  /**
   * Remove freebusies
   *
   * @param Yalesov\Vcard\Entity\Freebusy $freebusies
   */
  public function removeFreebusie(\Yalesov\Vcard\Entity\Freebusy $freebusies)
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
   * @param  Yalesov\Vcard\Entity\Calendar $calendars
   * @return Vcard
   */
  public function addCalendar(\Yalesov\Vcard\Entity\Calendar $calendars)
  {
    $this->calendars[] = $calendars;

    return $this;
  }

  /**
   * Remove calendars
   *
   * @param Yalesov\Vcard\Entity\Calendar $calendars
   */
  public function removeCalendar(\Yalesov\Vcard\Entity\Calendar $calendars)
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
   * @param  Yalesov\Vcard\Entity\CalendarRequest $calendarRequests
   * @return Vcard
   */
  public function addCalendarRequest(\Yalesov\Vcard\Entity\CalendarRequest $calendarRequests)
  {
    $this->calendarRequests[] = $calendarRequests;

    return $this;
  }

  /**
   * Remove calendarRequests
   *
   * @param Yalesov\Vcard\Entity\CalendarRequest $calendarRequests
   */
  public function removeCalendarRequest(\Yalesov\Vcard\Entity\CalendarRequest $calendarRequests)
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
