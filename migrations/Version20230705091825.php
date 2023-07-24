<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705091825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD updater_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2E37ECFB0 FOREIGN KEY (updater_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2E37ECFB0 ON service (updater_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2E37ECFB0');
        $this->addSql('DROP INDEX IDX_E19D9AD2E37ECFB0 ON service');
        $this->addSql('ALTER TABLE service DROP updater_id');
    }
}
