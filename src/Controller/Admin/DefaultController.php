<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller\Admin
 * @Route("/admin", name="admin_")
 */
class DefaultController extends Controller {
  /**
   * @Route("/", name="dashboard")
   * @return Response
   */
  public function index() {
    return $this->render("admin/index.html.twig");
  }
}