<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Twig;

use S4Blog\Config\Config;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ConfigTwigExtension extends AbstractExtension {
  /**
   * @var Config
   */
  private $config;

  public function __construct(Config $config) {
    $this->config = $config;
  }

  public function getFunctions() {
    return [
      new TwigFunction("s4blog_getConfig", [$this, "getConfig"])
    ];
  }

  public function getConfig($value, $defaultValue = "") {
    return $this->config->getProperty($value, $defaultValue);
  }
}