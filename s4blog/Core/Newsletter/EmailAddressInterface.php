<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Newsletter;

interface EmailAddressInterface {
  public function getEmailAddress();
  public function getHash();
  public function isConfirmed();
  public function acceptsEmails();
}