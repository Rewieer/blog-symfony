<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Template;


class TemplateConfigurator {
  /**
   * @var TemplateConfigurationInterface[]
   */
  private $configurations;

  public function __construct() {

  }

  public function add(TemplateConfigurationInterface $configuration) {
    $this->configurations[$configuration::getIdentifier()] = $configuration;
  }

  public function has($key) {
    return array_key_exists($key, $this->configurations);
  }

  public function get($key) {
    return $this->configurations[$key];
  }

  public function clear() {
    $this->configurations = [];
  }
}