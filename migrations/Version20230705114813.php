<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705114813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_information ADD county_id INT NOT NULL, ADD country_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_information ADD CONSTRAINT FK_8062D11685E73F45 FOREIGN KEY (county_id) REFERENCES county (id)');
        $this->addSql('ALTER TABLE user_information ADD CONSTRAINT FK_8062D116F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_8062D11685E73F45 ON user_information (county_id)');
        $this->addSql('CREATE INDEX IDX_8062D116F92F3E70 ON user_information (country_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_information DROP FOREIGN KEY FK_8062D11685E73F45');
        $this->addSql('ALTER TABLE user_information DROP FOREIGN KEY FK_8062D116F92F3E70');
        $this->addSql('DROP INDEX IDX_8062D11685E73F45 ON user_information');
        $this->addSql('DROP INDEX IDX_8062D116F92F3E70 ON user_information');
        $this->addSql('ALTER TABLE user_information DROP county_id, DROP country_id');
    }
}
