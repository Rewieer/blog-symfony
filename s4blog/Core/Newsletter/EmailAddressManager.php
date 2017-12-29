<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Newsletter;

use Doctrine\ORM\EntityManagerInterface;

class EmailAddressManager {
  /**
   * @var EmailAddressRepositoryInterface|null
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

    if ($this->repository instanceof EmailAddressRepositoryInterface === false) {
      throw new \Exception(sprintf("class %s must implement ArticleRepositoryInterface", $class));
    }
  }

  public function getEmailAddresses(EmailAddressRepositoryConfig $config) {
    return $this->repository->getEmailAddresses($config);
  }

  public function save(EmailAddressInterface $emailAddress) {
    if ($this->em->contains($emailAddress) === false) {
      $this->em->persist($emailAddress);
    }

    $this->em->flush();
  }
}