<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Article;

use S4Blog\Core\Common\RepositoryConfig;

class ArticleRepositoryConfig extends RepositoryConfig {
  private $publicOnly;

  public function __construct(array $params) {
    $this->publicOnly = $params["publicOnly"] ?? true;
    parent::__construct($params);
  }

  /**
   * @return bool|mixed
   */
  public function isPublicOnly() {
    return $this->publicOnly;
  }
}