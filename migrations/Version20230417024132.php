<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230417024132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vreserv (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, evname VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, tell VARCHAR(255) NOT NULL, INDEX IDX_9615A75CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vreserv ADD CONSTRAINT FK_9615A75CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event CHANGE image image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vreserv DROP FOREIGN KEY FK_9615A75CA76ED395');
        $this->addSql('DROP TABLE vreserv');
        $this->addSql('ALTER TABLE event CHANGE image image VARCHAR(255) DEFAULT NULL');
    }
}
