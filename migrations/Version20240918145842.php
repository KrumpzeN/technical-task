<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240918145842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Modify total_volume column to BIGINT';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE crypto_currency MODIFY total_volume BIGINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE crypto_currency MODIFY total_volume INT NOT NULL');
    }
}
