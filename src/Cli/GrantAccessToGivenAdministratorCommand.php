<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Cli;

use Sylius\RbacPlugin\Cli\Granter\AdministratorAccessGranterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class GrantAccessToGivenAdministratorCommand extends Command
{
    /** @var AdministratorAccessGranterInterface */
    private $administratorAccessGranter;

    public function __construct(AdministratorAccessGranterInterface $administratorAccessGranter)
    {
        parent::__construct('sylius-rbac:grant-access-to-given-administrator');
        $this->administratorAccessGranter = $administratorAccessGranter;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Grants access to chosen sections for administrator')
            ->addArgument('administratorEmail', InputOption::VALUE_REQUIRED)
            ->addArgument('roleName', InputOption::VALUE_REQUIRED)
            ->addArgument('sections', InputArgument::IS_ARRAY | InputOption::VALUE_REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        try {
            $this->administratorAccessGranter->__invoke(
                $input->getArgument('administratorEmail'),
                $input->getArgument('roleName'),
                $input->getArgument('sections')
            );
        } catch (\InvalidArgumentException $exception) {
            $output->writeln($exception->getMessage());
        }
    }
}
