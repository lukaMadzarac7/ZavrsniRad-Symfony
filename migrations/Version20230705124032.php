<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705124032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_rating ADD user_id INT NOT NULL, ADD rating_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_rating ADD CONSTRAINT FK_BDDB3D1FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_rating ADD CONSTRAINT FK_BDDB3D1FA32EFC6 FOREIGN KEY (rating_id) REFERENCES rating (id)');
        $this->addSql('CREATE INDEX IDX_BDDB3D1FA76ED395 ON user_rating (user_id)');
        $this->addSql('CREATE INDEX IDX_BDDB3D1FA32EFC6 ON user_rating (rating_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_rating DROP FOREIGN KEY FK_BDDB3D1FA76ED395');
        $this->addSql('ALTER TABLE user_rating DROP FOREIGN KEY FK_BDDB3D1FA32EFC6');
        $this->addSql('DROP INDEX IDX_BDDB3D1FA76ED395 ON user_rating');
        $this->addSql('DROP INDEX IDX_BDDB3D1FA32EFC6 ON user_rating');
        $this->addSql('ALTER TABLE user_rating DROP user_id, DROP rating_id');
    }
}
