<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220115454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subscriber (id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, email VARCHAR(250) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AD005B69E7927C74 ON subscriber (email)');
        $this->addSql('ALTER TABLE book ALTER authors TYPE TEXT');
        $this->addSql('ALTER TABLE book ALTER authors DROP NOT NULL');
        $this->addSql('ALTER TABLE book ALTER meap DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN book.authors IS \'\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CBE5A331989D9B62 ON book (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1FB30F98989D9B62 ON book_category (slug)');
        $this->addSql('ALTER TABLE book_book_category DROP CONSTRAINT FK_7A5A379440B1D29E');
        $this->addSql('ALTER TABLE book_book_category DROP CONSTRAINT book_book_category_pkey');
        $this->addSql('ALTER TABLE book_book_category ADD CONSTRAINT FK_7A5A379440B1D29E FOREIGN KEY (book_category_id) REFERENCES book_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book_book_category ADD PRIMARY KEY (book_category_id, book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE subscriber');
        $this->addSql('DROP INDEX UNIQ_CBE5A331989D9B62');
        $this->addSql('ALTER TABLE book ALTER authors TYPE TEXT');
        $this->addSql('ALTER TABLE book ALTER authors SET NOT NULL');
        $this->addSql('ALTER TABLE book ALTER meap SET DEFAULT false');
        $this->addSql('COMMENT ON COLUMN book.authors IS \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE book_book_category DROP CONSTRAINT fk_7a5a379440b1d29e');
        $this->addSql('DROP INDEX book_book_category_pkey');
        $this->addSql('ALTER TABLE book_book_category ADD CONSTRAINT fk_7a5a379440b1d29e FOREIGN KEY (book_category_id) REFERENCES book_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book_book_category ADD PRIMARY KEY (book_id, book_category_id)');
        $this->addSql('DROP INDEX UNIQ_1FB30F98989D9B62');
    }
}