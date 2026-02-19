<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260207085606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD type VARCHAR(255) NOT NULL, ADD weight INT DEFAULT NULL, ADD width INT DEFAULT NULL, ADD height INT DEFAULT NULL, ADD stock INT DEFAULT NULL, ADD depth INT DEFAULT NULL, ADD license_key VARCHAR(255) DEFAULT NULL, ADD download_url VARCHAR(255) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP type, DROP weight, DROP width, DROP height, DROP stock, DROP depth, DROP license_key, DROP download_url, CHANGE description description VARCHAR(255) DEFAULT NULL');
    }
}
