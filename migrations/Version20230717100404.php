<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230717100404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_image DROP INDEX UNIQ_6C4FE9B8ED5CA9E6, ADD INDEX IDX_6C4FE9B8ED5CA9E6 (service_id)');
        $this->addSql('ALTER TABLE service_image ADD service_id_id INT DEFAULT NULL, CHANGE service_id service_id INT NOT NULL');
        $this->addSql('ALTER TABLE service_image ADD CONSTRAINT FK_6C4FE9B8D63673B0 FOREIGN KEY (service_id_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_6C4FE9B8D63673B0 ON service_image (service_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_image DROP INDEX IDX_6C4FE9B8ED5CA9E6, ADD UNIQUE INDEX UNIQ_6C4FE9B8ED5CA9E6 (service_id)');
        $this->addSql('ALTER TABLE service_image DROP FOREIGN KEY FK_6C4FE9B8D63673B0');
        $this->addSql('DROP INDEX IDX_6C4FE9B8D63673B0 ON service_image');
        $this->addSql('ALTER TABLE service_image DROP service_id_id, CHANGE service_id service_id INT DEFAULT NULL');
    }
}
