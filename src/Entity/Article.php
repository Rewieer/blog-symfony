<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use S4Blog\Core\Article\ArticleInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article implements ArticleInterface {
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(nullable=false, type="string", length=255)
   */
  private $title;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $slug;

  /**
   * @ORM\Column(type="text")
   */
  private $preview;

  /**
   * @ORM\Column(type="text")
   */
  private $content;

  /**
   * @ORM\Column(type="boolean", length=255)
   */
  private $isDraft;

  /**
   * @ORM\Column(type="datetime", length=255)
   */
  private $createdAt;

  /**
   * @ORM\Column(type="text")
   */
  private $keywords;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\User")
   * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
   */
  private $author;

  public function getId() {
    return $this->id;
  }

  public function __construct(User $author, $title = "Sans Titre") {
    $this->author = $author;
    $this->createdAt = new \DateTime();
    $this->content = "";
    $this->title = $title;
    $this->isDraft = true;
    $this->slug = "sans-titre";
    $this->keywords = "";
  }

  /**
   * @return mixed
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * @param mixed $title
   * @return Article
   */
  public function setTitle($title) {
    $this->title = $title;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getSlug() {
    return $this->slug;
  }

  /**
   * @param mixed $slug
   * @return Article
   */
  public function setSlug($slug) {
    $this->slug = $slug;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getContent() {
    return $this->content;
  }

  /**
   * @param mixed $content
   * @return Article
   */
  public function setContent($content) {
    $this->content = $content;
    return $this;
  }

  /**
   * @return mixed
   */
  public function isDraft() {
    return $this->isDraft;
  }

  /**
   * @param bool $isDraft
   * @return Article
   */
  public function setDraft(bool $isDraft) {
    $this->isDraft = $isDraft;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getCreatedAt() {
    return $this->createdAt;
  }

  /**
   * @param mixed $createdAt
   * @return Article
   */
  public function setCreatedAt($createdAt) {
    $this->createdAt = $createdAt;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getAuthor() {
    return $this->author;
  }

  /**
   * @param mixed $author
   * @return Article
   */
  public function setAuthor($author) {
    $this->author = $author;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getKeywords() {
    return $this->keywords;
  }

  /**
   * @param mixed $keywords
   * @return Article
   */
  public function setKeywords($keywords) {
    $this->keywords = $keywords;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getPreview() {
    return $this->preview;
  }

  /**
   * @param mixed $preview
   * @return Article
   */
  public function setPreview($preview) {
    $this->preview = $preview;
    return $this;
  }
}
