<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Config;

use Symfony\Component\Yaml\Yaml;

/**
 * Class ConfigLoader
 * @package S4Blog\Config
 *
 * Loads the configuration
 */
class ConfigLoader {
  private $data;

  public function __construct(string $dir) {
    $filePath = $dir. "/s4blog/config.yaml";
    if (is_file($filePath) === false) {
      throw new \Exception("You must register a blog.yaml file in the config folder");
    }

    $this->data = Yaml::parse(file_get_contents($filePath));
  }

  /**
   * @param string $path
   * @param mixed|null $defaultValue
   * @return mixed|null
   */
  public function getProperty(string $path, $defaultValue = null) {
    return $this->doGetProperty($path, $defaultValue, $this->data);
  }

  /**
   * @param $path
   * @param mixed|null $defaultValue
   * @param $data
   * @return mixed|null
   */
  private function doGetProperty($path, $defaultValue = null, $data) {
    if (strpos($path, ".") === false) {
      if (array_key_exists($path, $data)) {
        return $data[$path];
      } else {
        return $defaultValue;
      }
    } else {
      $arrayPath = explode(".", $path);
      $head = array_shift($arrayPath);
      if (array_key_exists($head, $data)) {
        return $this->doGetProperty(implode(".", $arrayPath), $defaultValue, $data[$head]);
      } else {
        return $defaultValue;
      }
    }


  }

}