<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Common;

class DeepPath {
  /**
   * dpath implementation
   * return a value deep in the array hierarchy
   * @param $data
   * @param $path
   * @return null
   */
  public static function get($data, $path) {
    $key = array_shift($path);
    if (array_key_exists($key, $data)) {
      if (empty($path)) {
        return $data[$key];
      } else {
        return self::get($data[$key], $path);
      }
    }

    return null;
  }

  /**
   * Set a value deep in the array
   * @param $path
   * @param $data
   * @param $array
   */
  public static function set($path, $data, &$array) {
    $key = array_shift($path);
    if (array_key_exists($key, $array) === false) {
      if (empty($path)) {
        $array[$key] = $data;
      } else {
        $array[$key] = [];
      }
    }

    if (!empty($path)) {
      self::set($path, $data, $array[$key]);
    }
  }
}