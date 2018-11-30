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
            'command' => 'grant-access',
            'message' => 'Grants access to given sections to specified administrator',
            'parameters' => [
                'roleName' => 'Configurator',
                'sections' => ['configuration', 'rbac'],
            ]
        ],
    ];

    protected function configure(): void
    {
        $this
            ->setName('sylius-rbac:install-plugin')
            ->setDescription('Installs RBAC plugin')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $outputStyle = new SymfonyStyle($input, $output);
        $outputStyle->writeln('<info>Installing RBAC plugin...</info>');

        /** @var boolean $errored */
        $errored = false;

        foreach ($this->commands as $step => $command) {
            try {
                $outputStyle->newLine();
                $outputStyle->section(sprintf(
                    'Step %d of %d. <info>%s</info>',
                    $step + 1,
                    count($this->commands),
                    $command['message']
                ));

                $this->getApplication()
                    ->find('sylius-rbac:' . $command['command'])
                    ->run(new ArrayInput($command['parameters']), $output)
                ;
            } catch (\Exception $e) {
                $errored = true;
            }
        }

        $outputStyle->newLine(2);
        $outputStyle->success($this->getProperFinalMessage($errored));
    }

    private function getProperFinalMessage(bool $errored): string
    {
        if ($errored) {
            return 'RBAC has been installed, but some error occurred.';
        }
        return 'RBAC has been successfully installed.';
    }
}
