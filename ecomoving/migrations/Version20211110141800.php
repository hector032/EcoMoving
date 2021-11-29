<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211110141800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('CREATE INDEX role_id ON user (role_id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT fk_roleId FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP INDEX role_id ON user');
        $this->addSql('ALTER TABLE user DROP CONSTRAINT fk_roleId');
    }
}
