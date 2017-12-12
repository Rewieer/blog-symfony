<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog;

use S4Blog\Config\Config;
use S4Blog\Config\ConfigLoader;

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

  public function __construct(string $configDir) {
    $this->config = new Config(new ConfigLoader($configDir));
  }
}