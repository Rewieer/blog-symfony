<?php

namespace App\Form;

use App\Entity\EmailAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailAddressType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add("emailAddress", EmailType::class, [
        "label" => "Adresse e-mail",
      ])
      ->add("isConfirmed", CheckboxType::class, [
        "label" => "Cette adresse e-mail est confirmée",
        "required" => false,
      ])
      ->add("acceptsEmails", CheckboxType::class, [
        "label" => "Cette personne accepte de recevoir des e-mails",
        "required" => false,
      ])
      ->add("hash", HiddenType::class)
    ;
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      "data_class" => EmailAddress::class,
    ]);
  }
}
