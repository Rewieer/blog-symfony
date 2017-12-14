<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Media;

class MediaUploadResult {
  private $path;
  private $isSuccess;

  /**
   * MediaUploadResult constructor.
   * @param $path
   * @param $isSuccess
   */
  public function __construct($path, $isSuccess) {
    $this->path = $path;
    $this->isSuccess = $isSuccess;
  }


  /**
   * @return mixed
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * @param mixed $path
   * @return MediaUploadResult
   */
  public function setPath($path) {
    $this->path = $path;
    return $this;
  }

  /**
   * @return mixed
   */
  public function isSuccess() {
    return $this->isSuccess;
  }
}