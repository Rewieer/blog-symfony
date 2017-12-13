<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Command;

use App\Entity\User;
use App\Service\UserManager;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateUserCommand
 * @package App\Command
 *
 * Allows to create user from the command line
 */
class CreateUserCommand extends Command {
  private $userManager;

  public function __construct(UserManager $userManager) {
    $this->userManager = $userManager;
    parent::__construct();
  }

  /**
   * Configure the command
   */
  protected function configure() {
    $this
      ->setName("app:create-user")
      ->setDescription("Creates a new user")
      ->setHelp("First argument must be the e-mail, second argument the password. The user's name will be 'Admin'")
      ->addArgument("email", InputArgument::REQUIRED, "The email")
      ->addArgument("password", InputArgument::REQUIRED, "The password")
    ;
  }

  /**
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return int|null|void
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $email = $input->getArgument("email");
    $password = $input->getArgument("password");

    $user = new User($email, $password);
    $user->setName("Admin");

    try {
      $this->userManager->register($user);
      $output->writeln(sprintf("<info>The user <comment>%s</comment> has been created with password <comment>%s</comment>", $email, $password));
    } catch (UniqueConstraintViolationException $e) {
      $output->writeln(sprintf("Impossible to create the user, the e-mail address is already used."));
    }
  }
}