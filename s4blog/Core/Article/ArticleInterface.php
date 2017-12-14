<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Article;

interface ArticleInterface {
  public function getTitle();
  public function getAuthor();
  public function getSlug();
  public function getContent();
  public function isDraft();
  public function getCreatedAt();
}