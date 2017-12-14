<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use S4Blog\Core\Article\ArticleRepositoryConfig;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller\Admin
 * @Route("/admin", name="admin_")
 */
class ArticleController extends Controller {
  /**
   * @Route("/articles/list/{page}", name="article_list")
   * @param $page
   * @return Response
   */
  public function listArticle($page = 1) {
    $page = intval($page);
    $list = $this->get("s4blog.article.manager")->getArticles(new ArticleRepositoryConfig([
      "page" => $page,
      "itemPerPage" => 30,
      "draftOnly" => false,
    ]));

    return $this->render("admin/article.list.html.twig", [
      "list" => $list,
    ]);
  }

  /**
   * @Route("/articles/new", name="article_new")
   * @return Response
   */
  public function newArticle(Request $request) {
    $article = new Article($this->getUser());

    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->get("s4blog.article.manager")->save($article);
      return $this->redirectToRoute("admin_article_list");
    }

    $this->get("s4blog.article.manager")->save($article);
    return $this->render("admin/article.form.html.twig", [
      "article" => $article,
      "form" => $form->createView()
    ]);
  }

  /**
   * @Route("/articles/edit/{id}", name="article_edit")
   * @return Response
   */
  public function editArticle(Article $article, Request $request) {
    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->get("s4blog.article.manager")->save($article);
      return $this->redirectToRoute("admin_article_list");
    }

    return $this->render("admin/article.form.html.twig", [
      "article" => $article,
      "form" => $form->createView()
    ]);
  }
}