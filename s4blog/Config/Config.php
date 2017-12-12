<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Config;

/**
 * Class Config
 * @package S4Blog\Config
 * Holds the configuration of the blog, read-only
 */
class Config {
  private $title;
  private $googleAnalyticsTag;

  public function __construct(ConfigLoader $loader) {
    $this->title = $loader->getProperty("title");
    $this->googleAnalyticsTag = $loader->getProperty("google_analytics.gtag");
  }

  /**
   * @return mixed
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * @return mixed
   */
  public function getGoogleAnalyticsTag() {
    return $this->googleAnalyticsTag;
  }
}