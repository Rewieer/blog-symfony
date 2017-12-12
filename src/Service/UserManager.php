<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserManager {
  /**
   * @var EntityManagerInterface
   */
  private $em;

  /**
   * @var UserRepository
   */
  private $repository;

  public function __construct(EntityManagerInterface $em) {
    $this->em = $em;
    $this->repository = $em->getRepository("App:User");
  }

  /**
   * @param User $user
   */
  public function register(User $user) {
    $this->em->persist($user);
    $this->em->flush();
  }
}