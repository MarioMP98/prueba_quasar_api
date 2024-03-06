<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306223852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD created_at TIMESTAMP(0)');
        $this->addSql('ALTER TABLE user ADD updated_at TIMESTAMP(0)');
        $this->addSql('ALTER TABLE user ADD deleted_at TIMESTAMP(0)');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP created_at');
        $this->addSql('ALTER TABLE user DROP updated_at');
        $this->addSql('ALTER TABLE user DROP deleted_at');

    }
}
