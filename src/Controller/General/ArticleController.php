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
    $this->configureTemplate("facebook-opengraph", [
      "og:locale" => "en_US",
      "og:type" => "website",
      "og:title" => $article->getTitle(),
      "og:description" => $article->getPreview(),
      "og:url" => $this->generateUrl("article_view", [
        "id" => $article->getId(),
        "slug" => $article->getSlug(),
      ], true),
      "og:site_name" => $this->get("s4blog.config")->getProperty("title"),
      "og:image" => $article->getCoverImage(),
      "article:publisher" => $this->get("s4blog.config")->getProperty("social_networks.facebook"),
      "article:published_time" => $article->getCreatedAt()->format(\DateTime::RFC3339)
    ]);

    $twitterName = "@" .substr(
      $this->get("s4blog.config")->getProperty("social_networks.twitter"),
    20);

    $this->configureTemplate("twitter-cards", [
      "twitter:card" => "summary_large_image",
      "twitter:description" => $article->getPreview(),
      "twitter:title" => $article->getTitle(),
      "twitter:site" => $twitterName,
      "twitter:image" => $article->getCoverImage(),
      "twitter:creator" => $twitterName,
    ]);

    return $this->render("article.html.twig", [
      "article" => $article,
    ]);
  }
}