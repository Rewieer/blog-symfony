<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Media;

use Symfony\Bridge\Twig\Extension\HttpFoundationExtension;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class FilesystemMediaDriver
 * @package S4Blog\Core\Media
 * Driver to manage files stored in the file system
 */
class FilesystemMediaDriver implements MediaDriverInterface {
  private $directory;
  private $httpPath;
  private $httpFoundationExtension;

  public function __construct(string $directory, HttpFoundationExtension $extension, Packages $package) {
    $this->directory = $directory;
    $this->httpFoundationExtension = $extension;

    $path = substr($this->directory, strpos($this->directory, "s4b"));
    $path = $package->getUrl($path);
    $this->httpPath = $this->httpFoundationExtension->generateAbsoluteUrl($path);
  }

  /**
   * @param UploadedFile $file
   * @return string
   */
  private function getUniqueName(UploadedFile $file) {
    $path = null;
    do {
      $name = md5(uniqid(). $file->getClientOriginalName()). "." .$file->guessExtension();
      $path = $this->directory. "/" .$name;
      $exists = file_exists($path);
    } while ($exists === true);
    return $name;
  }

  /**
   * Return the file absolute URL
   * @param $filename
   * @return string
   */
  private function absoluteUrl($filename) {
    return $this->httpPath."/" .$filename;
  }

  /**
   * @param UploadedFile $file
   * @return MediaUploadResult
   * @throws \Exception
   */
  public function upload(UploadedFile $file) : MediaUploadResult {
    if (is_dir($this->directory) === false) {
      try {
        mkdir($this->directory, 0775, true);
      } catch (\Exception $e) {
        throw new \Exception("Cannot create the media directory");
      }
    }

    $name = $this->getUniqueName($file);
    $file->move($this->directory, $name);

    return new MediaUploadResult($this->absoluteUrl($name), true);
  }
}