<?php

namespace Finconsult\Documentor\Shared\Contexts\Security\Infrastructure\Controller\CLI;

use Finconsult\Documentor\Shared\Contexts\Security\Application\Command\CreateAdmin\Command as CreateUserCommand;
use Finconsult\Documentor\Shared\Contexts\Security\Application\Command\CreateAdmin\Handler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:security:create-admin')]
class CreateAdmin extends Command
{
    public function __construct(private Handler $handler, $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription('Создаёт или обновляет существующую учётную запись администратора.')
            ->addArgument('email', InputArgument::REQUIRED, 'Почта')
            ->addArgument('name', InputArgument::REQUIRED, 'Имя')
            ->addArgument('password', InputArgument::REQUIRED, 'Пароль');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $outputStream = new SymfonyStyle($input, $output);

        $command = new CreateUserCommand(
            $input->getArgument('email'),
            $input->getArgument('name'),
            $input->getArgument('password')
        );

        try {
            $this->handler->handle($command);
        } catch (\Throwable $exception) {
            $outputStream->error('Во время создания или обновления учётной записи администратора произошла ошибка: ' . $exception->getMessage());

            return Command::FAILURE;
        }

        $outputStream->success('Учётная запись администратора успешно создана или обновлена!');

        return Command::SUCCESS;
    }
}
