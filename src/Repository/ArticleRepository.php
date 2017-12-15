<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use S4Blog\Core\Article\ArticleRepositoryInterface;
use S4Blog\Core\Common\PaginatedList;
use S4Blog\Core\Article\ArticleRepositoryConfig;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ArticleRepository extends ServiceEntityRepository implements ArticleRepositoryInterface {
  public function __construct(RegistryInterface $registry) {
    parent::__construct($registry, Article::class);
  }

  /**
   * Return the amount of articles
   * @param ArticleRepositoryConfig $config
   * @return int
   * @throws \Doctrine\ORM\NoResultException
   * @throws \Doctrine\ORM\NonUniqueResultException
   */
  public function getCount(ArticleRepositoryConfig $config) {
    $qb = $this->_em->createQueryBuilder();
    $qb
      ->select("COUNT(a)")
      ->from("App:Article", "a");

    if ($config->isPublicOnly()) {
      $qb->andWhere("a.isDraft = 0");
    }

    return $qb->getQuery()->getSingleScalarResult();
  }

  /**
   * Return a paginated list of articles
   * @param ArticleRepositoryConfig $config
   * @return PaginatedList
   * @throws \Doctrine\ORM\NoResultException
   * @throws \Doctrine\ORM\NonUniqueResultException
   */
  public function getArticles(ArticleRepositoryConfig $config) : PaginatedList {
    $count = $this->getCount($config);
    $qb = $this->createQueryBuilder("a");
    $qb
      ->setFirstResult(($config->getPage() - 1) * $config->getItemsPerPage())
      ->setMaxResults($config->getItemsPerPage())
    ;

    if ($config->isPublicOnly()) {
      $qb->andWhere("a.isDraft = 0");
    }

    return new PaginatedList($config, $count, $qb->getQuery()->getResult());
  }
}
