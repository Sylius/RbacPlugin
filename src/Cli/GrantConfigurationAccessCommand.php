<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Cli;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RbacPlugin\Access\Model\OperationType;
use Sylius\RbacPlugin\Entity\AdministrationRole;
use Sylius\RbacPlugin\Entity\AdminUserInterface;
use Sylius\RbacPlugin\Model\Permission;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class GrantConfigurationAccessCommand extends Command
{
    /** @var RepositoryInterface */
    private $administratorRepository;

    /** @var RepositoryInterface */
    private $administratorRoleRepository;

    /** @var ObjectManager */
    private $objectManager;

    public function __construct(RepositoryInterface $administratorRepository, RepositoryInterface $administratorRoleRepository, ObjectManager $objectManager)
    {
        parent::__construct('sylius-rbac:grant-configuration-access');

        $this->administratorRepository = $administratorRepository;
        $this->administratorRoleRepository = $administratorRoleRepository;
        $this->objectManager = $objectManager;
    }

    protected function configure()
    {
        $this
            ->setName('sylius-rbac:grant-configuration-access')
            ->setDescription('Grants access to specific section for administrator')
            ->addArgument('email', InputOption::VALUE_REQUIRED)
            ->addArgument('section', InputOption::VALUE_REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var AdminUserInterface $admin */
        $admin = $this->administratorRepository->findOneBy(['email' => $input->getArgument('email')]);

        $configuratorRole = new AdministrationRole();
        $configuratorRole->setName('Configurator2');
        $configuratorRole->addPermission(Permission::configuration([OperationType::write()]));

        $this->administratorRoleRepository->add($configuratorRole);

        $admin->setAdministrationRole($configuratorRole);

        $this->objectManager->flush();
    }
}
