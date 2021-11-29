<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211108114542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD category_id INT NOT NULL');
        $this->addSql('CREATE INDEX category_id ON product (category_id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT fk_categoryId FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE ');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX category_id ON product');
        $this->addSql('ALTER TABLE product DROP COLUMN category_id');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT fk_categoryId');
    }
}
