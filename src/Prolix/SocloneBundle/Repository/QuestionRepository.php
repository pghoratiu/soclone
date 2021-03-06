<?php

namespace Prolix\SocloneBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * QuestionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionRepository extends EntityRepository
{
  public function getLatestQuestions($limit = null)
  {
    $qb = $this->createQueryBuilder('b')
               ->select('b')
               ->addOrderBy('b.created', 'DESC');

    if (false === is_null($limit))
      $limit = 20;
  
    $qb->setMaxResults($limit);

    return $qb->getQuery()->getResult();
  }
}
