<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Cli;

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
            'message' => 'Grants access to given sections to specified administrator',
            'parameters' => [
                'roleName' => 'Configurator',
                'sections' => ['configuration', 'rbac'],
            ],
            'interactive' => true,
        ],
    ];

    protected function configure(): void
    {
        $this
            ->setName('sylius-rbac:install-plugin')
            ->setDescription('Installs RBAC plugin')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $outputStyle = new SymfonyStyle($input, $output);
        $outputStyle->writeln('<info>Installing RBAC plugin...</info>');

        foreach ($this->commands as $step => $command) {
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

                return;
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
}
