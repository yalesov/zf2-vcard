<?php

namespace Yalesov\Vcard\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Type
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Type extends EntityRepository
{
  const WORK = 'work';
  const HOME = 'home';
}
