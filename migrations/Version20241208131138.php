<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241208131138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Create authors table
        $this->addSql('CREATE TABLE authors (
            id SERIAL NOT NULL,
            name VARCHAR(100) NOT NULL,
            category VARCHAR(100) NOT NULL,
            PRIMARY KEY(id)
        )');

        // Create articles table with a foreign key constraint
        $this->addSql('CREATE TABLE articles (
            id SERIAL NOT NULL,
            title VARCHAR(100) NOT NULL,
            content TEXT NOT NULL,
            author_id INT NOT NULL,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            PRIMARY KEY(id),
            CONSTRAINT fk_author_id FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE CASCADE
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE authors');
    }
}