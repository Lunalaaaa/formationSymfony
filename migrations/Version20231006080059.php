<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231006080059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__films AS SELECT id, title, poster, country, realease_at, plot, price, age FROM films');
        $this->addSql('DROP TABLE films');
        $this->addSql('CREATE TABLE films (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, poster VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, realease_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , plot CLOB NOT NULL, price INTEGER DEFAULT NULL, age INTEGER NULL)');
        $this->addSql('INSERT INTO films (id, title, poster, country, realease_at, plot, price, age) SELECT id, title, poster, country, realease_at, plot, price, age FROM __temp__films');
        $this->addSql('DROP TABLE __temp__films');
        $this->addSql('ALTER TABLE user ADD COLUMN age INTEGER DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__films AS SELECT id, title, poster, country, realease_at, plot, price, age FROM films');
        $this->addSql('DROP TABLE films');
        $this->addSql('CREATE TABLE films (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, poster VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, realease_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , plot CLOB NOT NULL, price INTEGER DEFAULT NULL, age INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO films (id, title, poster, country, realease_at, plot, price, age) SELECT id, title, poster, country, realease_at, plot, price, age FROM __temp__films');
        $this->addSql('DROP TABLE __temp__films');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, roles, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, username, roles, password) SELECT id, username, roles, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }
}
