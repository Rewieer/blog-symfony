<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\Config;

use S4Blog\Core\BlogApplication;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class ConfigForm {
  /**
   * @var BlogApplication
   */
  private $application;

  /**
   * @var FormFactoryInterface
   */
  private $formFactory;

  /**
   * @var FormInterface
   */
  private $form;

  private $metadata;

  public function __construct(BlogApplication $application, FormFactoryInterface $formFactory, ConfigMetadata $metadata) {
    $this->application = $application;
    $this->formFactory = $formFactory;
    $this->metadata = $metadata;
  }

  public function getMetadata($key) {
    return $this->metadata->get($key);
  }

  public function build() {
    $values = $this->application->getConfig()->getValues();
    $valuesClone = [];
    $formKeyMapping = [];

    foreach ($values as $key => $value) {
      $formKey = str_replace(".", ":", $key);
      $valuesClone[$formKey] = $value;
      $formKeyMapping[$formKey] = $key;
    }

    $this->form = $this->formFactory->create(FormType::class, $valuesClone);
    foreach ($valuesClone as $key => $value) {
      $metadata = $this->getMetadata($formKeyMapping[$key]);
      if (!is_array($metadata)) {
        $metadata = [];
      }

      $this->form->add($key, TextType::class, $metadata);
    }
  }

  public function handle(Request $request) {
    $this->form->handleRequest($request);
    if ($this->form->isSubmitted() && $this->form->isValid()) {
      $arr = [];
      foreach ($this->form->getData() as $key => $value) {
        $arr[str_replace(":", ".", $key)] = $value;
      }

      $this->application->getConfig()->update($arr);
    }
  }

  public function hasSubmitted() {
    return false;
  }

  /**
   * @return FormInterface
   */
  public function getForm() {
    return $this->form;
  }
}