<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250107214615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP CONSTRAINT fk_author_id');
        $this->addSql('DROP SEQUENCE authors_id_seq CASCADE');
        $this->addSql('CREATE TABLE comments (id SERIAL NOT NULL, content TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "users" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, role VARCHAR(20) DEFAULT \'GUEST\' NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "users" (email)');
        $this->addSql('DROP TABLE authors');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168F675F31B FOREIGN KEY (author_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE articles DROP CONSTRAINT FK_BFDD3168F675F31B');
        $this->addSql('CREATE SEQUENCE authors_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE authors (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, category VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE "users"');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT fk_author_id FOREIGN KEY (author_id) REFERENCES authors (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
