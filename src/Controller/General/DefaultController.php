<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\General;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller {
  /**
   * @Route("/")
   * @return Response
   */
  public function index() {
    return $this->render("index.html.twig");
  }

  /**
   * @Route("/login", name="login")
   * @return Response
   */
  public function login() {
    $authUtils = $this->get('security.authentication_utils');
    $error = $authUtils->getLastAuthenticationError();
    $lastUsername = $authUtils->getLastUsername();


    return $this->render("login.html.twig", [
      "error" => $error,
      "lastUsername" => $lastUsername,
    ]);
  }
}