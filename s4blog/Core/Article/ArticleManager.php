<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Article;

use Doctrine\ORM\EntityManagerInterface;

class ArticleManager {
  /**
   * @var ArticleRepositoryInterface|null
   */
  private $repository;

  /**
   * @var EntityManagerInterface
   */
  private $em;

  public function __construct($entityClass, EntityManagerInterface $em) {
    $this->em = $em;
    $this->injectEntityClass($entityClass);
  }

  /**
   * Loads the repository
   * @param string $class
   * @throws \Exception
   */
  public function injectEntityClass(string $class) {
    if (class_exists($class) === false) {
      throw new \Exception(sprintf("class %s does not exist", $class));
    }

    $this->repository = $this->em->getRepository($class);
    if ($this->repository === null) {
      throw new \Exception(sprintf("repository %s does not exist", $class));
    }

    if ($this->repository instanceof ArticleRepositoryInterface === false) {
      throw new \Exception(sprintf("class %s must implement ArticleRepositoryInterface", $class));
    }
  }

  public function getArticles(ArticleRepositoryConfig $config) {
    return $this->repository->getArticles($config);
  }

  public function save(ArticleInterface $article) {
    if ($this->em->contains($article) === false) {
      $this->em->persist($article);
    }

    $this->em->flush();
  }
}