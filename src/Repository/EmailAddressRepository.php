<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\EmailAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use S4Blog\Core\Newsletter\EmailAddressRepositoryConfig;
use S4Blog\Core\Common\PaginatedList;
use S4Blog\Core\Newsletter\EmailAddressRepositoryInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EmailAddressRepository extends ServiceEntityRepository implements EmailAddressRepositoryInterface {
  public function __construct(RegistryInterface $registry) {
    parent::__construct($registry, EmailAddress::class);
  }

  /**
   * Return the amount of articles
   * @param EmailAddressRepositoryConfig $config
   * @return int
   * @throws \Doctrine\ORM\NoResultException
   * @throws \Doctrine\ORM\NonUniqueResultException
   */
  public function getCount(EmailAddressRepositoryConfig $config) {
    $qb = $this->_em->createQueryBuilder();
    $qb
      ->select("COUNT(e)")
      ->from("App:EmailAddress", "e");

    if ($config->isAuthorizedOnly()) {
      $qb->andWhere("e.acceptsEmails = 1 AND e.isConfirmed = 1");
    }

    return $qb->getQuery()->getSingleScalarResult();
  }

  /**
   * @param EmailAddressRepositoryConfig $config
   * @return PaginatedList
   * @throws \Doctrine\ORM\NoResultException
   * @throws \Doctrine\ORM\NonUniqueResultException
   */
  public function getEmailAddresses(EmailAddressRepositoryConfig $config): PaginatedList {
    $count = $this->getCount($config);
    $qb = $this->createQueryBuilder("e");
    $qb
      ->setFirstResult(($config->getPage() - 1) * $config->getItemsPerPage())
      ->setMaxResults($config->getItemsPerPage())
    ;

    if ($config->isAuthorizedOnly()) {
      $qb->andWhere("e.acceptsEmails = 1 AND e.isConfirmed = 1");
    }

    return new PaginatedList($config, $count, $qb->getQuery()->getResult());
  }
}
