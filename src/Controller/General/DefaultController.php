<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\General;

use S4Blog\Core\Article\ArticleRepositoryConfig;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller {
  /**
   * @Route("/{page}", name="homepage", requirements={"page": "\d+"})
   * @return Response
   */
  public function index($page = 1) {
//    $client = $this->get("s4blog.google_analytics.client");
//    $result = $client->getPageViewsDateRange(
//      "166425057",
//      "2017-11-29",
//      "today",
//    "/");

    $page = intval($page);
    $list = $this->get("s4blog.article.manager")->getArticles(new ArticleRepositoryConfig([
      "page" => $page,
      "itemPerPage" => 30,
      "publicOnly" => true,
    ]));

    return $this->render("index.html.twig", [
      "list" => $list,
    ]);
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