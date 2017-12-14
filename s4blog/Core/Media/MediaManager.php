<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Media;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class MediaUploader
 * @package S4Blog\Core\Media
 * Bridge over the media managment
 */
class MediaManager {
  private $driver;

  public function __construct(MediaDriverInterface $driver) {
    $this->driver = $driver;
  }

  /**
   * @param UploadedFile $file
   * @return array
   * @throws \Exception
   */
  public function upload(UploadedFile $file) {
    $result = $this->driver->upload($file);
    return [
      "status" => $result->isSuccess() ? "OK" : "ERROR",
      "path" => $result->getPath(),
    ];
  }
}