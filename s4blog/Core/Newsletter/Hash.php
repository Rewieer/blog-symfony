<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Newsletter;

class Hash {
  private static $alphas;
  private static $alphasCount;

  private static function randomChar() {
    return self::$alphas[rand(0, self::$alphasCount - 1)];
  }

  public static function generate($amount = 6) {
    if (self::$alphas === null) {
      self::$alphas = array_merge(range('A', 'Z'), range(0, 9));
      self::$alphasCount = count(self::$alphas);
    }

    $str = "";
    for ($i = 0; $i < $amount; $i++) {
      $str .= self::randomChar();
    }
    return $str;
  }
}