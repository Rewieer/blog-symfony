<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller\Admin
 * @Route("/admin", name="admin_")
 */
class SettingsController extends Controller {
  /**
   * @Route("/settings/blog", name="settings_blog")
   * @return Response
   */
  public function blogSettings(Request $request) {
    $configForm = $this->get("s4blog.config.form");
    $configForm->build();
    $configForm->handle($request);
    if ($configForm->hasSubmitted()) {

    }

    return $this->render("admin/settings_blog.html.twig", [
      "form" => $configForm->getForm()->createView()
    ]);
  }
}
