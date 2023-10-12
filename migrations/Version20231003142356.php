<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231003142356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add source language to translations';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE translations ADD source_language_id INT DEFAULT NULL, DROP source');
        $this->addSql('ALTER TABLE translations ADD CONSTRAINT FK_C6B7DA87BE8EEA54 FOREIGN KEY (source_language_id) REFERENCES languages (id)');
        $this->addSql('CREATE INDEX IDX_C6B7DA87BE8EEA54 ON translations (source_language_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE translations DROP FOREIGN KEY FK_C6B7DA87BE8EEA54');
        $this->addSql('DROP INDEX IDX_C6B7DA87BE8EEA54 ON translations');
        $this->addSql('ALTER TABLE translations ADD source VARCHAR(255) NOT NULL, DROP source_language_id');
    }
}
