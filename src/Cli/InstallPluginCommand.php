<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Cli;

use Sylius\RbacPlugin\Provider\SyliusSectionsProviderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class InstallPluginCommand extends Command
{
    /** @var array */
    private $commands = [
        [
            'command' => 'sylius:fixtures:load',
            'message' => 'Loads default no sections access role',
            'parameters' => [
                'suite' => 'default_administration_role',
            ],
            'interactive' => false,
        ],
        [
            'command' => 'sylius-rbac:normalize-administrators',
            'message' => 'Assigns new, default role to all administrators in the system',
            'parameters' => [],
            'interactive' => false,
        ],
        [
            'command' => 'sylius-rbac:grant-access',
            'message' => 'Grants access to given sections to specified administrator (via cli)',
            'parameters' => [
                'roleName' => 'Configurator',
                // based on config.yml file and added during command's execution
                'sections' => [],
            ],
            'interactive' => true,
        ],
        [
            'command' => 'sylius-rbac:grant-access-to-given-administrator',
            'message' => 'Grants access to given sections to specified administrator (via configuration)',
            'parameters' => [
                'roleName' => 'Configurator',
                // based on config.yml file and added during command's execution
                'sections' => [],
                'administratorEmail' => '',
            ],
            'interactive' => true,
        ],
    ];

    /** @var SyliusSectionsProviderInterface */
    private $syliusSectionsProvider;

    /** @var string */
    private $administratorEmail;

    public function __construct(
        SyliusSectionsProviderInterface $syliusSectionsProvider,
        string $administratorEmail
    ) {
        parent::__construct();
        $this->syliusSectionsProvider = $syliusSectionsProvider;
        $this->administratorEmail = $administratorEmail;
    }

    protected function configure(): void
    {
        $this
            ->setName('sylius-rbac:install-plugin')
            ->setDescription('Installs RBAC plugin');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $outputStyle = new SymfonyStyle($input, $output);
        $outputStyle->writeln('<info>Installing RBAC plugin...</info>');

        foreach ($this->commands as $step => $command) {
            if (!$this->shouldCommandBeExecuted($command)) {
                continue;
            }

            if ($this->shouldCommandBeNormalized($command)) {
                $command = $this->normalizeCommand($command);
            }

            try {
                $outputStyle->newLine();
                $outputStyle->section($this->getCommandMessage($step, $command['message']));

                $input = new ArrayInput($command['parameters']);
                $input->setInteractive($command['interactive']);

                $this->getApplication()
                    ->find($command['command'])
                    ->run($input, $output)
                ;
            } catch (\Exception $exception) {
                $outputStyle->newLine(2);
                $outputStyle->warning($exception->getMessage());
            }
        }

        $outputStyle->newLine(2);
        $outputStyle->success('RBAC has been successfully installed.');
    }

    private function getCommandMessage(int $step, string $commandMessage): string
    {
        return sprintf('Step %d of %d. <info>%s</info>',
            $step + 1,
            count($this->commands),
            $commandMessage
        );
    }

    private function shouldCommandBeExecuted(array $command): bool
    {
        /** @var bool $isAdministratorEmailProvided */
        $isAdministratorEmailProvided = $this->isAdministratorEmailProvided();

        /** @var bool $isGrantAccessToGivenAdministratorCurrentCommand */
        $isGrantAccessToGivenAdministratorCurrentCommand =
            $this->isGrantAccessToGivenAdministratorCurrentCommand($command['command']);

        /** @var bool $isGrantAccessCurrentCommand */
        $isGrantAccessCurrentCommand = $this->isGrantAccessCurrentCommand($command['command']);

        return !(($isGrantAccessToGivenAdministratorCurrentCommand && !$isAdministratorEmailProvided) ||
            ($isGrantAccessCurrentCommand && $isAdministratorEmailProvided));
    }

    private function shouldCommandBeNormalized(array $command): bool
    {
        return $this->isGrantAccessCurrentCommand($command['command']) ||
            $this->isGrantAccessToGivenAdministratorCurrentCommand($command['command']);
    }

    private function normalizeCommand(array $command): array
    {
        $command['parameters']['sections'] = $this->syliusSectionsProvider->__invoke();

        if ($this->isGrantAccessToGivenAdministratorCurrentCommand($command['command'])) {
            $command['parameters']['administratorEmail'] = $this->administratorEmail;
        }

        return $command;
    }

    private function isGrantAccessToGivenAdministratorCurrentCommand(string $commandName): bool
    {
        return $commandName === 'sylius-rbac:grant-access-to-given-administrator';
    }

    private function isGrantAccessCurrentCommand(string $commandName): bool
    {
        return $commandName === 'sylius-rbac:grant-access';
    }

    private function isAdministratorEmailProvided(): bool
    {
        return !empty($this->administratorEmail);
    }
}
