<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller\Admin
 * @Route(name="s4blog_")
 */
class FileAsyncController extends Controller {
  /**
   * @Route("media/upload", name="media_upload", options={"expose"=true})
   * @param Request $request
   * @return JsonResponse
   * @throws \Exception
   */
  public function uploadFile(Request $request) {
    if ($request->files->has("file")) {
      $file = $request->files->get("file");
      $mediaManager = $this->get("s4blog.media.media_manager");
      $data = $mediaManager->upload($file);
      return new JsonResponse($data);
    }

    return new JsonResponse([], 400);
  }
}