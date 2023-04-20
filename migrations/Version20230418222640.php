<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230418222640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clent ADD reserv_id INT NOT NULL');
        $this->addSql('ALTER TABLE clent ADD CONSTRAINT FK_8B4A48FC71A855B0 FOREIGN KEY (reserv_id) REFERENCES reserve (id)');
        $this->addSql('CREATE INDEX IDX_8B4A48FC71A855B0 ON clent (reserv_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clent DROP FOREIGN KEY FK_8B4A48FC71A855B0');
        $this->addSql('DROP INDEX IDX_8B4A48FC71A855B0 ON clent');
        $this->addSql('ALTER TABLE clent DROP reserv_id');
    }
}
