<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Facebook;

use S4Blog\Core\Template\TemplateConfigurationInterface;

class FacebookOpenGraphTemplateConfiguration implements TemplateConfigurationInterface {
  private $data;
  private $twig;

  public function __construct(\Twig_Environment $twig) {
    $this->twig = $twig;
  }

  public function configure(array $data) {
    $this->data = $data;
  }

  public function render(): string {
    return $this->twig->render("@S4Blog/Template/facebook_opengraph.html.twig", [
      "data" => $this->data,
    ]);
  }

  public static function getIdentifier(): string {
    return "facebook-opengraph";
  }
}