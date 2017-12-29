<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", unique=true)
   */
  private $email;

  /**
   * @ORM\Column(type="string")
   */
  private $password;

  /**
   * @var string|null
   */
  private $plainPassword = null;

  /**
   * @ORM\Column(type="string")
   */
  private $name;

  /**
   * @return string
   */
  public function serialize() {
    return serialize([$this->id, $this->email, $this->password]);
  }

  /**
   * @param string $serialized
   */
  public function unserialize($serialized) {
    list (
      $this->id,
      $this->email,
      $this->password
      ) = unserialize($serialized);
  }

  /**
   * @return mixed
   */
  public function getRoles() {
    return ["ROLE_ADMIN"];
  }

  /**
   * @return string
   */
  public function getPassword() {
    return $this->password;
  }

  /**
   * @param mixed $password
   * @return User
   */
  public function setPassword($password) {
    $this->password = $password;
    return $this;
  }

  /**
   * @return null|string
   */
  public function getSalt() {
    return null;
  }

  /**
   * @return string
   */
  public function getUsername() {
    return $this->email;
  }

  /**
   * @return void
   */
  public function eraseCredentials() {
    $this->plainPassword = null;
  }

  /**
   * User constructor.
   * @param string $email
   * @param string $password
   */
  public function __construct(string $email, string $password) {
    $this->email = $email;
    $this->plainPassword = $password;
  }

  /**
   * @return mixed
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return mixed
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * @param mixed $email
   * @return User
   */
  public function setEmail($email) {
    $this->email = $email;
    return $this;
  }

  /**
   * @return null|string
   */
  public function getPlainPassword() {
    return $this->plainPassword;
  }

  /**
   * @param null|string $plainPassword
   * @return User
   */
  public function setPlainPassword($plainPassword) {
    $this->plainPassword = $plainPassword;
    $this->password = null;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @param mixed $name
   * @return User
   */
  public function setName($name) {
    $this->name = $name;
    return $this;
  }
}
