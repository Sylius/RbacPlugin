<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Cli;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Entity\AdminUserInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class NormalizeExistingAdministratorsCommand extends Command
{
    /** @var RepositoryInterface */
    private $administratorRepository;

    /** @var RepositoryInterface */
    private $administratorRoleRepository;

    /** @var ObjectManager */
    private $objectManager;

    public function __construct(
        RepositoryInterface $administratorRepository,
        RepositoryInterface $administratorRoleRepository,
        ObjectManager $objectManager
    ) {
        parent::__construct('sylius-rbac:normalize-administrators');

        $this->administratorRepository = $administratorRepository;
        $this->administratorRoleRepository = $administratorRoleRepository;
        $this->objectManager = $objectManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Assign no sections access role to all administrators in the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        /** @var AdministrationRoleInterface|null $noSectionsAccessRole */
        $noSectionsAccessRole = $this->administratorRoleRepository->findOneBy(['name' => 'No sections access']);

        if (null === $noSectionsAccessRole) {
            $output->writeln('There is no role with no access to any section. Aborting.');
            return;
        }

        /** @var array $administrators */
        $administrators = $this->administratorRepository->findAll();

        /** @var AdminUserInterface $administrator */
        foreach ($administrators as $administrator) {
            $administrator->setAdministrationRole($noSectionsAccessRole);
        }

        $this->objectManager->flush();
    }
}
