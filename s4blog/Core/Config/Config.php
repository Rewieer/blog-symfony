<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Config;
use S4Blog\Core\Common\DeepPath;

/**
 * Class Config
 * @package S4Blog\Config
 * Holds the configuration of the blog, read-only
 */
class Config {
  private $data;
  private $values;
  private $driver;

  public function __construct(ConfigDriverInterface $driver) {
    $this->driver = $driver;
    $this->data = $driver->read();
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

  /**
   * Return the keys
   * @return array
   */
  public function getKeys() {
    if ($this->values === null) {
      $this->values = [];
      $this->doLoadValues();
    }

    return array_keys($this->values);
  }

  /**
   * Actually load the keys
   * @param array|null $data
   * @param string $currentKey
   */
  private function doLoadValues($data = null, $currentKey = "") {
    if ($data === null) {
      $data = $this->data;
    }

    if (is_string($currentKey) === false) {
      $currentKey = "";
    }

    foreach ($data as $key => $value) {
      if (is_scalar($value)) {
        $this->values[$currentKey.$key] = $value;
      } else {
        $this->doLoadValues($data[$key], $currentKey. $key. ".");
      }
    }
  }

  /**
   * Return the values
   * @return array|null
   */
  public function getValues() {
    if ($this->values === null) {
      $this->values = [];
      $this->doLoadValues();
    }

    return $this->values;
  }

  /**
   * Update the current values
   * @param array $data
   * @throws \Exception
   */
  public function update(array $data) {
    $this->values = $data;
    $nextData = [];
    foreach ($data as $key => $value) {
      DeepPath::set(explode(".", $key), $value, $nextData);
    }

    $this->data = $nextData;
    $this->save();
  }

  /**
   * Saves the current config in the file
   * @throws \Exception
   */
  public function save() {
    $this->driver->write($this->data);
  }
}