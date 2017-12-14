<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Common;

class RepositoryConfig {
  private $page;
  private $itemsPerPage;

  public function __construct(array $params) {
    $this->page = $params["page"] ?? 1;
    $this->itemsPerPage = $params["itemsPerPage"] ?? 30;
  }

  /**
   * @return int|mixed
   */
  public function getPage() {
    return $this->page;
  }

  /**
   * @return mixed
   */
  public function getItemsPerPage() {
    return $this->itemsPerPage;
  }
}