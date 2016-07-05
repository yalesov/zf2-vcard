<?php

namespace Yalesov\Vcard\Repository;

use Doctrine\ORM\EntityRepository;
use Yalesov\Vcard\Exception;

/**
 * Vcard
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Vcard extends EntityRepository
{
    const VERSION = '4.0';

    /**
     * generic string-based search method for Vcards
     * search for string in any of:
     *  - uid
     *  - source
     *  - formattedName
     *  - name
     *  - nickname
     *  - address
     *  - phone
     *  - email
     *  - im
     *  - url
     *  - title
     *  - role
     *  - org
     *  - member
     *  - tag
     *  - note
     *
     * @param  string $criteria a comma-separated list of strings to search for
     * @param  int    $limit    = 0
     * @param  int    $offset   = 0
     * @return array  of Vcard
     */
    public function textSearch($criteria = '', $limit = 0, $offset = 0)
    {
        if (!is_string($criteria)) {
            throw new Exception\InvalidArgumentException(
                '$criteria should be a comma-separated string'
            );
        }
        foreach (array('limit', 'offset') as $var) {
            if (!is_int($$var)) {
                throw new Exception\InvalidArgumentException(sprintf(
                    '$%s should be int.',
                    $var
                ));
            }
        }

        $dqb = $this->_em->createQueryBuilder();
        $dqb->select(array('v'))
            ->from('Vcard\Entity\Vcard', 'v')
            ->leftJoin('v.uid', 'uid')
            ->leftJoin('v.sources', 'src')
            ->leftJoin('v.formattedNames', 'fn')
            ->leftJoin('v.names', 'n')
            ->leftJoin('n.familyNames', 'nf')
            ->leftJoin('n.givenNames', 'ng')
            ->leftJoin('n.additionalNames', 'na')
            ->leftJoin('n.prefixes', 'np')
            ->leftJoin('n.suffixes', 'ns')
            ->leftJoin('v.nicknames', 'nn')
            ->leftJoin('nn.values', 'nnv')
            ->leftJoin('v.addresses', 'adr')
            ->leftJoin('v.phones', 'ph')
            ->leftJoin('v.emails', 'em')
            ->leftJoin('v.ims', 'im')
            ->leftJoin('v.urls', 'url')
            ->leftJoin('v.titles', 'tle')
            ->leftJoin('v.roles', 'rle')
            ->leftJoin('v.orgs', 'org')
            ->leftJoin('v.members', 'mbr')
            ->leftJoin('v.tags', 'tag')
            ->leftJoin('tag.values', 'tv')
            ->leftJoin('v.notes', 'nte');

        $where = array();
        if ($criteria) {
            $criteriaFiltered = array();
            foreach (explode(',', $criteria) as $term) {
                $term = trim($term);
                $criteriaFiltered[$term] = $term;
            }
            foreach ($criteriaFiltered as $key => $term) {
                $where[] = $dqb->expr()->like('uid.value', ":term$key");
                $where[] = $dqb->expr()->like('src.value', ":term$key");
                $where[] = $dqb->expr()->like('fn.value', ":term$key");
                $where[] = $dqb->expr()->like('nf.value', ":term$key");
                $where[] = $dqb->expr()->like('ng.value', ":term$key");
                $where[] = $dqb->expr()->like('na.value', ":term$key");
                $where[] = $dqb->expr()->like('np.value', ":term$key");
                $where[] = $dqb->expr()->like('ns.value', ":term$key");
                $where[] = $dqb->expr()->like('nnv.value', ":term$key");
                $where[] = $dqb->expr()->like('adr.street', ":term$key");
                $where[] = $dqb->expr()->like('adr.locality', ":term$key");
                $where[] = $dqb->expr()->like('adr.region', ":term$key");
                $where[] = $dqb->expr()->like('adr.postalCode', ":term$key");
                $where[] = $dqb->expr()->like('adr.country', ":term$key");
                $where[] = $dqb->expr()->like('ph.value', ":term$key");
                $where[] = $dqb->expr()->like('em.value', ":term$key");
                $where[] = $dqb->expr()->like('im.value', ":term$key");
                $where[] = $dqb->expr()->like('url.value', ":term$key");
                $where[] = $dqb->expr()->like('tle.value', ":term$key");
                $where[] = $dqb->expr()->like('rle.value', ":term$key");
                $where[] = $dqb->expr()->like('org.value', ":term$key");
                $where[] = $dqb->expr()->like('mbr.value', ":term$key");
                $where[] = $dqb->expr()->like('tv.value', ":term$key");
                $where[] = $dqb->expr()->like('nte.value', ":term$key");

                $dqb->setParameter("term$key", "%$term%");
            }

            $dqb->where(call_user_func_array(
                    array($dqb->expr(), 'orX'),
                    $where
                ));
        }

        $dqb->groupBy('v.id')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $dqb->getQuery()->getResult();
    }
}