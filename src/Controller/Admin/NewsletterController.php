<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\EmailAddress;
use App\Form\ArticleType;
use App\Form\EmailAddressType;
use S4Blog\Core\Newsletter\EmailAddressRepositoryConfig;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller\Admin
 * @Route("/admin", name="admin_")
 */
class NewsletterController extends Controller {
  /**
   * @Route("/newsletter/mails/list/{page}", name="newsletter_list_email_address")
   * @param $page
   * @return Response
   */
  public function listEmailAddresses($page = 1) {
    $page = intval($page);
    $list = $this
      ->get("s4blog.newsletter.email_address.manager")
      ->getEmailAddresses(new EmailAddressRepositoryConfig([
        "page" => $page,
        "itemsPerPage" => 10,
        "authorizedOnly" => false,
      ]));

    return $this->render("admin/email_address.list.html.twig", [
      "list" => $list,
    ]);
  }

  /**
   * @Route("/newsletter/mails/new", name="newsletter_new_email_address")
   * @return Response
   */
  public function newEmailAddress(Request $request) {
    $emailAddress = new EmailAddress();

    $form = $this->createForm(EmailAddressType::class, $emailAddress);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->get("s4blog.newsletter.email_address.manager")->save($emailAddress);
      return $this->redirectToRoute("admin_newsletter_list_email_address");
    }

    return $this->render("admin/email_address.form.html.twig", [
      "form" => $form->createView()
    ]);
  }

  /**
   * @Route("/newsletter/mails/edit/{id}", name="newsletter_edit_email_address")
   * @return Response
   */
  public function editEmailAddress(EmailAddress $emailAddress, Request $request) {
    $form = $this->createForm(EmailAddressType::class, $emailAddress);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->get("s4blog.newsletter.email_address.manager")->save($emailAddress);
      return $this->redirectToRoute("admin_newsletter_list_email_address");
    }

    return $this->render("admin/email_address.form.html.twig", [
      "form" => $form->createView()
    ]);
  }

  /**
   * @Route("/newsletter/write", name="newsletter_write")
   * @return Response
   */
  public function writeEmail(EmailAddress $emailAddress, Request $request) {
    $form = $this->createForm(EmailAddressType::class, $emailAddress);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->get("s4blog.newsletter.email_address.manager")->save($emailAddress);
      return $this->redirectToRoute("admin_newsletter_list_email_address");
    }

    return $this->render("admin/email_address.form.html.twig", [
      "form" => $form->createView()
    ]);
  }
}