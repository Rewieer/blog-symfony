<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Config;

use Symfony\Component\Yaml\Yaml;

/**
 * Class ConfigDriver
 * @package S4Blog\Config
 * Manage IO operations
 */
class ConfigDriver implements ConfigDriverInterface {
  private $data;
  private $path;

  public function __construct(string $path) {
    if (is_file($path) === false) {
      throw new \Exception(sprintf("The file %s hasn't been found", $path));
    }

    if (is_readable($path) === false || is_writable($path) === false) {
      throw new \Exception("The file must be readable AND writable");
    }

    $this->path = $path;
  }

  /**
   * Load the data from the config file and return it
   * @return mixed
   */
  public function read() {
    if ($this->data === null) {
      $this->data = Yaml::parse(file_get_contents($this->path));
    }

    return $this->data;
  }

  /**
   * Replace the configuration content
   * @param $data
   * @throws \Exception
   */
  public function write(array $data) {
    if (is_writable($this->path) === false) {
      throw new \Exception("Cannot write over the configuration file, please check your permissions.");
    }

    $this->data = file_put_contents($this->path, Yaml::dump($data));
  }
}