<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Newsletter;

use S4Blog\Core\Common\RepositoryConfig;

class EmailAddressRepositoryConfig extends RepositoryConfig {
  private $authorizedOnly;

  public function __construct(array $params) {
    $this->authorizedOnly = $params["authorizedOnly"] ?? true;
    parent::__construct($params);
  }

  /**
   * @return bool|mixed
   */
  public function isAuthorizedOnly() {
    return $this->authorizedOnly;
  }
}