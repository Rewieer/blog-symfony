<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TemplateConfiguratorPass implements CompilerPassInterface {
  public function process(ContainerBuilder $container) {
    $def = $container->findDefinition("s4blog.template.configurator");
    $templates = $container->findTaggedServiceIds("s4b.template.configuration");

    foreach ($templates as $id => $tags) {
      $def->addMethodCall("add", [new Reference($id)]);
    }
  }
}