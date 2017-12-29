<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Newsletter;

use S4Blog\Core\Common\PaginatedList;

interface EmailAddressRepositoryInterface {
  public function getEmailAddresses(EmailAddressRepositoryConfig $config) : PaginatedList;
}