<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Template;
use \Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

class Controller extends BaseController {
  public function configureTemplate($class, array $data) {
    $configurator = $this->get("s4blog.template.configurator");
    if ($configurator->has($class)) {
      $configurator->get($class)->configure($data);
    }
  }
}