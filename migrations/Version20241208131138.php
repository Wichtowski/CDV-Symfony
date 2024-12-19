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
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles (
            id SERIAL NOT NULL,
            title VARCHAR(100) NOT NULL,
            content TEXT NOT NULL,
            author_id INT NOT NULL,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            PRIMARY KEY(id))',);
        $this->addSql('CONSTRAINT FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE CASCADE');
        $this->addSql('CREATE TABLE authors (
            id SERIAL NOT NULL,
            `name` VARCHAR(100) NOT NULL,
            category VARCHAR(100) NOT NULL,
            PRIMARY KEY(id))',
        ); 

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE articles');
    }
}
