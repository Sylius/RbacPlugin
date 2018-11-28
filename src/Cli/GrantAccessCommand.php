<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Cli;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RbacPlugin\Access\Model\OperationType;
use Sylius\RbacPlugin\Entity\AdministrationRole;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Entity\AdminUserInterface;
use Sylius\RbacPlugin\Model\Permission;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class GrantAccessCommand extends Command
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
        parent::__construct('sylius-rbac:grant-access');

        $this->administratorRepository = $administratorRepository;
        $this->administratorRoleRepository = $administratorRoleRepository;
        $this->objectManager = $objectManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Grants access to chosen sections for administrator')
            ->addArgument('email', InputOption::VALUE_REQUIRED)
            ->addArgument('roleName', InputOption::VALUE_REQUIRED)
            ->addArgument('sections', InputArgument::IS_ARRAY | InputOption::VALUE_REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var AdminUserInterface $admin */
        $admin = $this->administratorRepository->findOneBy(['email' => $input->getArgument('email')]);

        /** @var string $roleName */
        $roleName = $input->getArgument('roleName');

        $administrationRole = $this->getOrCreateAdministrationRole($roleName);

        /** @var array $sections */
        $sections = $input->getArgument('sections');

        foreach ($sections as $section) {
            $administrationRole->addPermission(
                Permission::ofType(
                    $section,
                    [OperationType::read(), OperationType::write()])
            );
        }

        $this->administratorRoleRepository->add($administrationRole);
        $admin->setAdministrationRole($administrationRole);

        $this->objectManager->flush();
    }

    private function getOrCreateAdministrationRole(string $roleName): AdministrationRoleInterface
    {
        // This behaviour is debatable - either just override the selected role or throw an exception.
        /** @var AdministrationRoleInterface|null $administrationRole */
        $administrationRole = $this->administratorRoleRepository->findOneBy(['name' => $roleName]);

        if (null === $administrationRole) {
            $administrationRole = new AdministrationRole();
            $administrationRole->setName($roleName);
        }

        return $administrationRole;
    }
}
