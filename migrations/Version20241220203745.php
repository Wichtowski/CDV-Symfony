<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241220203745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Check if the 'articles' table already exists
        if (!$schema->hasTable('articles')) {
            $this->addSql('CREATE TABLE articles (
                id SERIAL NOT NULL,
                title VARCHAR(100) NOT NULL,
                content TEXT NOT NULL,
                author_id INT NOT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                PRIMARY KEY(id)
            )');
        }

        // Check if the 'authors' table already exists
        if (!$schema->hasTable('authors')) {
            $this->addSql('CREATE TABLE authors (
                id SERIAL NOT NULL,
                name VARCHAR(100) NOT NULL,
                category VARCHAR(100) NOT NULL,
                PRIMARY KEY(id)
            )');
        }

        // Add foreign key constraint if it doesn't exist
        if (!$schema->getTable('articles')->hasForeignKey('FK_BFDD3168F675F31B')) {
            $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168F675F31B FOREIGN KEY (author_id) REFERENCES authors (id) ON DELETE CASCADE');
        }
    }

    public function down(Schema $schema): void
    {
        // Drop foreign key and tables if they exist
        if ($schema->getTable('articles')->hasForeignKey('FK_BFDD3168F675F31B')) {
            $this->addSql('ALTER TABLE articles DROP CONSTRAINT FK_BFDD3168F675F31B');
        }
        
        if ($schema->hasTable('articles')) {
            $this->addSql('DROP TABLE articles');
        }

        if ($schema->hasTable('authors')) {
            $this->addSql('DROP TABLE authors');
        }
    }
}