<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231005132450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE films ADD COLUMN age INTEGER');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__films AS SELECT id, title, poster, country, realease_at, plot, price FROM films');
        $this->addSql('DROP TABLE films');
        $this->addSql('CREATE TABLE films (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, poster VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, realease_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , plot CLOB NOT NULL, price INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO films (id, title, poster, country, realease_at, plot, price) SELECT id, title, poster, country, realease_at, plot, price FROM __temp__films');
        $this->addSql('DROP TABLE __temp__films');
    }
}
