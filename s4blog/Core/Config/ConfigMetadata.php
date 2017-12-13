<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Config;

use S4Blog\Core\Common\DeepPath;
use Symfony\Component\Yaml\Yaml;

class ConfigMetadata {
  private $path;

  /**
   * @var Config
   */
  private $config;

  /**
   * @var array|null
   */
  private $metadata;

  public function __construct(Config $config, string $path) {
    $this->config = $config;
    $this->path = $path;
  }

  /**
   * Return the metadata about the config
   * @param $key
   * @return array
   */
  public function get($key) {
    if ($this->metadata === null) {
      $this->loadMetadata();
    }

    return array_key_exists($key, $this->metadata) ? $this->metadata[$key] : [];
  }

  /**
   * Load the metadata
   */
  private function loadMetadata() {
    $data = Yaml::parse(file_get_contents($this->path));
    $this->metadata = [];

    foreach ($this->config->getKeys() as $dpath) {
      $this->metadata[$dpath] = DeepPath::get($data, explode(".", $dpath));
    }
  }
}