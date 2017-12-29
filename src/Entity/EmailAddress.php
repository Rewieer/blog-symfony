<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use S4Blog\Core\Newsletter\EmailAddressInterface;
use S4Blog\Core\Newsletter\Hash;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailAddressRepository")
 */
class EmailAddress implements EmailAddressInterface {
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(nullable=false, type="string", length=255)
   */
  private $emailAddress;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $hash;

  /**
   * @ORM\Column(type="boolean")
   */
  private $isConfirmed;

  /**
   * @ORM\Column(type="boolean")
   */
  private $acceptsEmails;

  /**
   * @ORM\Column(type="datetime")
   */
  private $createdAt;

  public function getId() {
    return $this->id;
  }

  public function __construct(string $emailAddress = "", string $hash = null) {
    if (!$hash) {
      $hash = Hash::generate(8);
    }

    $this->emailAddress = $emailAddress;
    $this->createdAt = new \DateTime();
    $this->isConfirmed = false;
    $this->acceptsEmails = false;
    $this->hash = $hash;
  }

  /**
   * @return mixed
   */
  public function getEmailAddress() {
    return $this->emailAddress;
  }

  /**
   * @param mixed $emailAddress
   */
  public function setEmailAddress($emailAddress) {
    $this->emailAddress = $emailAddress;
  }

  /**
   * @return mixed
   */
  public function getHash() {
    return $this->hash;
  }

  /**
   * @param mixed $hash
   */
  public function setHash($hash) {
    $this->hash = $hash;
  }

  /**
   * @return mixed
   */
  public function isConfirmed() {
    return $this->isConfirmed;
  }

  /**
   * @param mixed $isConfirmed
   */
  public function setIsConfirmed($isConfirmed) {
    $this->isConfirmed = $isConfirmed;
  }

  /**
   * @return mixed
   */
  public function acceptsEmails() {
    return $this->acceptsEmails;
  }

  /**
   * @param mixed $acceptsEmails
   */
  public function setAcceptsEmails($acceptsEmails) {
    $this->acceptsEmails = $acceptsEmails;
  }

  /**
   * @return mixed
   */
  public function getCreatedAt() {
    return $this->createdAt;
  }

  /**
   * @param mixed $createdAt
   */
  public function setCreatedAt($createdAt) {
    $this->createdAt = $createdAt;
  }
}
