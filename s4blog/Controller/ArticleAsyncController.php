<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller\Admin
 * @Route(name="s4blog_")
 */
class ArticleAsyncController extends Controller {
  /**
   * @Route("article/update/{id}", name="article_update", options={"expose"=true})
   * @param Request $request
   * @return JsonResponse
   * @throws \Exception
   */
  public function updateArticle(Article $article, Request $request) {
    // TODO : dont use the article type directly here
    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->get("s4blog.article.manager")->save($article);
    }

    return new JsonResponse([], 200);
  }
}