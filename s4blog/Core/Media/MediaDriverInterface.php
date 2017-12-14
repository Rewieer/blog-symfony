<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Media;

use Symfony\Component\HttpFoundation\File\UploadedFile;

// TODO : add getFiles (with pagination) and remove
interface MediaDriverInterface {
  public function upload(UploadedFile $file) : MediaUploadResult;
}