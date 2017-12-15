<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Twig;

use S4Blog\Core\Template\TemplateConfigurator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TemplateConfiguratorTwigExtension extends AbstractExtension {
  /**
   * @var TemplateConfigurator
   */
  private $configurator;

  public function __construct(TemplateConfigurator $configurator) {
    $this->configurator = $configurator;
  }

  public function getFunctions() {
    return [
      new TwigFunction("s4blog_renderTemplate", [$this, "renderTemplate"])
    ];
  }

  public function renderTemplate($template) {
    if ($this->configurator->has($template)) {
      return $this->configurator->get($template)->render();
    }
  }
}