<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDoctrineEventSubscriber implements EventSubscriber {
  /**
   * @var UserPasswordEncoderInterface
   */
  private $encoder;

  public function __construct(UserPasswordEncoderInterface $encoder) {
    $this->encoder = $encoder;
  }

  public function getSubscribedEvents() {
    return ["prePersist", "preUpdate"];
  }

  /**
   * Encode the user's plain password
   * @param User $user
   */
  private function encodePassword(User $user) {
    if ($user->getPlainPassword() === null) {
      return;
    }

    $password = $this->encoder->encodePassword($user, $user->getPlainPassword());
    $user->setPassword($password);
  }

  /**
   * Ensure the user has an apikey and encodes his password
   * @param LifecycleEventArgs $args
   */
  public function prePersist(LifecycleEventArgs $args) {
    $entity = $args->getEntity();
    if ($entity instanceof User === false) {
      return;
    }

    $this->encodePassword($entity);
  }

  /**
   * Encodes password
   * @param LifecycleEventArgs $args
   */
  public function preUpdate(LifecycleEventArgs $args) {
    $entity = $args->getEntity();
    if ($entity instanceof User === false) {
      return;
    }

    $this->encodePassword($entity);

    // Trick to force doctrine into updating
    // See https://knpuniversity.com/screencast/symfony-security/encoding-user-password

    $em = $args->getEntityManager();
    $meta = $em->getClassMetadata(User::class);
    $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
  }
}