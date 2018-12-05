<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Cli;

use Sylius\RbacPlugin\Cli\Granter\AdministratorAccessGranterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

final class GrantAccessCommand extends Command
{
    /** @var AdministratorAccessGranterInterface */
    private $administratorAccessGranter;

    public function __construct(AdministratorAccessGranterInterface $administratorAccessGranter)
    {
        parent::__construct('sylius-rbac:grant-access');
        $this->administratorAccessGranter = $administratorAccessGranter;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Grants access to chosen sections for administrator')
            ->addArgument('roleName', InputOption::VALUE_REQUIRED)
            ->addArgument('sections', InputArgument::IS_ARRAY | InputOption::VALUE_REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $administratorEmail = $this->getAdministratorEmail($input, $output);

        try {
            $this->administratorAccessGranter->__invoke(
                $administratorEmail,
                $input->getArgument('roleName'),
                $input->getArgument('sections')
            );
        } catch (\InvalidArgumentException $exception) {
            $output->writeln($exception->getMessage());
        }
    }

    private function getAdministratorEmail(InputInterface $input, OutputInterface $output): string
    {
        $helper = $this->getHelper('question');
        $question = new Question(
            'In order to permit access to admin panel sections for given administrator, please provide administrator\'s email address: '
        );

        /** @var string $administratorEmail */
        return $helper->ask($input, $output, $question);
    }
}
