<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Common;

class PaginatedList {
  private $total;
  private $entities;
  private $page;
  private $maxPage;
  private $previousPage;
  private $nextPage;

  /**
   * PaginatedList constructor.
   * @param $config
   * @param $total
   * @param $entities
   */
  public function __construct(RepositoryConfig $config, int $total, $entities) {
    $this->total = $total;
    $this->entities = $entities;

    $this->page = $config->getPage();
    $this->maxPage =  intval(ceil($total / $config->getItemsPerPage()));
    $this->previousPage = $this->page === 1 ? -1 : $this->page - 1;
    $this->nextPage = $this->page === $this->maxPage ? -1 : $this->page + 1;
  }

  /**
   * @return int
   */
  public function getTotal() {
    return $this->total;
  }

  /**
   * @return mixed
   */
  public function getEntities() {
    return $this->entities;
  }

  /**
   * @return int|mixed
   */
  public function getPage() {
    return $this->page;
  }

  /**
   * @return int
   */
  public function getMaxPage() {
    return $this->maxPage;
  }

  /**
   * @return int|mixed
   */
  public function getPreviousPage() {
    return $this->previousPage;
  }

  /**
   * @return int|mixed
   */
  public function getNextPage() {
    return $this->nextPage;
  }
}