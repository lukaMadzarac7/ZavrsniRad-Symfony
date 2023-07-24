<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705094427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD service_field_id INT NOT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2BD415C8D FOREIGN KEY (service_field_id) REFERENCES service_field (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2BD415C8D ON service (service_field_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2BD415C8D');
        $this->addSql('DROP INDEX IDX_E19D9AD2BD415C8D ON service');
        $this->addSql('ALTER TABLE service DROP service_field_id');
    }
}
