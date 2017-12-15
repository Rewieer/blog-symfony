<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\General;

use App\Entity\Article;
use S4Blog\Core\Template\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller {
  /**
   * @Route("/article/{id}-{slug}", name="article_view")
   * @return Response
   */
  public function index(Article $article) {
    $this->configureTemplate("google-analytics", [
      "dimensions" => [
        "dimension1" => $article->getId(),
      ]
    ]);

    return $this->render("article.html.twig", [
      "article" => $article,
    ]);
  }
}