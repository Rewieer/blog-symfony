<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Media;


use Aws\S3\S3Client;
use S4Blog\Core\Config\Config;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class AWSMediaDriver
 * @package S4Blog\Core\Media
 * Allows to manage files uploaded to S3
 */
class AWSMediaDriver implements MediaDriverInterface {
  /**
   * @var string|null
   */
  private $bucket;

  /**
   * @var S3Client
   */
  private $client;

  public function __construct(Config $config) {
    $this->bucket = $config->getProperty("aws.s3.bucket");
    $this->client = new S3Client([
      "version" => $config->getProperty("aws.s3.version", "latest"),
      "region" => $config->getProperty("aws.s3.region"),
      "credentials" => [
        "key" => $config->getProperty("aws.credentials.key"),
        "secret" => $config->getProperty("aws.credentials.secret")
      ]
    ]);
  }

  /**
   * Ensure the bucket exists
   * TODO : this operation is slow, and often the bucket already exists, so it should be cached
   */
  public function ensureBucketExists() {
    if ($this->client->doesBucketExist($this->bucket) === false) {
      $this->client->createBucket([
        "Bucket" => $this->bucket
      ]);
      $this->client->waitUntil("BucketExists", ["Bucket" => $this->bucket]);
    }
  }

  /**
   * Return the content type of the file
   * @param UploadedFile $file
   * @return string
   */
  public function getContentType(UploadedFile $file) {
    $extension = $file->guessExtension();
    if (!$extension)
      $extension = 'alert';

    if ($extension === "jpeg")
      $extension = "jpg";

    $contentType = $extension === "jpg" ? "image/jpeg" : "image/png";
    return $contentType;
  }

  /**
   * Upload the file to AWS
   * @param UploadedFile $file
   * @return MediaUploadResult
   */
  public function upload(UploadedFile $file) : MediaUploadResult {
    $this->ensureBucketExists();
    $filename = md5(uniqid(). $file->getClientOriginalName()). "." .$file->guessExtension();
    $result = $this->client->putObject([
      "Bucket" => $this->bucket,
      "Key" => $filename,
      "ACL" => "public-read",
      "ContentType" => $this->getContentType($file),
      "SourceFile" => $file->getRealPath(),
    ]);

    if ($result->get("ObjectURL")) {
      return new MediaUploadResult($result->get("ObjectURL"), true);
    } else {
      return new MediaUploadResult(null, false);
    }
  }
}