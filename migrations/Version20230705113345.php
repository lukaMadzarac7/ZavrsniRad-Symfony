<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705113345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_information ADD city_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_information ADD CONSTRAINT FK_8062D1168BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_8062D1168BAC62AF ON user_information (city_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_information DROP FOREIGN KEY FK_8062D1168BAC62AF');
        $this->addSql('DROP INDEX IDX_8062D1168BAC62AF ON user_information');
        $this->addSql('ALTER TABLE user_information DROP city_id');
    }
}
