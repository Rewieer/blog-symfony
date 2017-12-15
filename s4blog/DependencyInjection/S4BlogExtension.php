<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class S4BlogExtension extends Extension {
  public function getNamespace() {
    return "s4blog";
  }

  public function load(array $configs, ContainerBuilder $container) {
    $loader = new YamlFileLoader(
      $container,
      new FileLocator(__DIR__. "/../Resources/config")
    );

    $loader->load("services.yaml");

    $container->setParameter("s4blog.article.entity",$configs[0]["article"]["entity"]);
    $container->setParameter("s4blog.article.form", $configs[0]["article"]["form"]);
    $container->setParameter("s4blog.google_analytics.auth_file_path", $configs[0]["google_analytics"]["auth_file_path"]);
  }
}