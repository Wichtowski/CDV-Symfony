<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241229123736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Drop the foreign key only if it exists
        $articlesTable = $schema->getTable('articles');
        if ($articlesTable->hasForeignKey('fk_bfdd3168f675f31b')) {
            $this->addSql('ALTER TABLE articles DROP CONSTRAINT fk_bfdd3168f675f31b');
        }
    
        $this->addSql('DROP SEQUENCE authors_id_seq CASCADE');
        $this->addSql('DROP TABLE authors');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD role JSON NOT NULL');
    }
    

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE authors_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE authors (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, category TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE articles DROP CONSTRAINT fk_bfdd3168f675f31b');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT fk_bfdd3168f675f31b FOREIGN KEY (author_id) REFERENCES authors (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" DROP role');
    }
}
