<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Article;

use S4Blog\Core\Common\PaginatedList;

interface ArticleRepositoryInterface {
  public function getArticles(ArticleRepositoryConfig $config) : PaginatedList;
}