<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190426102705 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_admin_user DROP FOREIGN KEY FK_88D5CC4D6557905D');
        $this->addSql('DROP INDEX IDX_88D5CC4D6557905D ON sylius_admin_user');
        $this->addSql('ALTER TABLE sylius_admin_user CHANGE administrationrole_id administration_role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_admin_user ADD CONSTRAINT FK_88D5CC4D913437BF FOREIGN KEY (administration_role_id) REFERENCES sylius_rbac_administration_role (id)');
        $this->addSql('CREATE INDEX IDX_88D5CC4D913437BF ON sylius_admin_user (administration_role_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_admin_user DROP FOREIGN KEY FK_88D5CC4D913437BF');
        $this->addSql('DROP INDEX IDX_88D5CC4D913437BF ON sylius_admin_user');
        $this->addSql('ALTER TABLE sylius_admin_user CHANGE administration_role_id administrationRole_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_admin_user ADD CONSTRAINT FK_88D5CC4D6557905D FOREIGN KEY (administrationRole_id) REFERENCES sylius_rbac_administration_role (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_88D5CC4D6557905D ON sylius_admin_user (administrationRole_id)');
    }
}
