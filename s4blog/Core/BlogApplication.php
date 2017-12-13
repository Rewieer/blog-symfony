<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core;

use S4Blog\Core\Config\Config;

/**
 * Class BlogApplication
 * @package S4Blog
 * Main object of S4Blog
 */
class BlogApplication {
  /**
   * @var Config
   */
  private $config;

  public function __construct(Config $config) {
    $this->config = $config;
  }

  /**
   * @return Config
   */
  public function getConfig() {
    return $this->config;
  }
}