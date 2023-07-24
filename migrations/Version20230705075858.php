<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705075858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD233663AF7');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD261220EA6');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2AC8DE0F');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2BD415C8D');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2E37ECFB0');
        $this->addSql('DROP INDEX IDX_E19D9AD2BD415C8D ON service');
        $this->addSql('DROP INDEX IDX_E19D9AD2E37ECFB0 ON service');
        $this->addSql('DROP INDEX IDX_E19D9AD2AC8DE0F ON service');
        $this->addSql('DROP INDEX IDX_E19D9AD261220EA6 ON service');
        $this->addSql('DROP INDEX IDX_E19D9AD233663AF7 ON service');
        $this->addSql('ALTER TABLE service DROP creator_id, DROP updater_id, DROP service_status_id, DROP service_type_id, DROP service_field_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD creator_id INT NOT NULL, ADD updater_id INT DEFAULT NULL, ADD service_status_id INT NOT NULL, ADD service_type_id INT NOT NULL, ADD service_field_id INT NOT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD233663AF7 FOREIGN KEY (service_status_id) REFERENCES service_status (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD261220EA6 FOREIGN KEY (creator_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2AC8DE0F FOREIGN KEY (service_type_id) REFERENCES service_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2BD415C8D FOREIGN KEY (service_field_id) REFERENCES service_field (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2E37ECFB0 FOREIGN KEY (updater_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E19D9AD2BD415C8D ON service (service_field_id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2E37ECFB0 ON service (updater_id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2AC8DE0F ON service (service_type_id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD261220EA6 ON service (creator_id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD233663AF7 ON service (service_status_id)');
    }
}
