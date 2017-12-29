<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add("title", TextType::class)
      ->add("content", TextareaType::class, [
        "required" => false,
      ])
      ->add("preview", TextareaType::class, [
        "required" => false,
      ])
      ->add("draft", CheckboxType::class, [
        "label" => "Mode Brouillon",
        "required" => false,
      ])
      ->add("slug", TextType::class)
      ->add("keywords", TextType::class, [
        "required" => false,
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      "data_class" => Article::class,
    ]);
  }
}
