<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190623092217 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD is_active TINYINT(1) DEFAULT \'1\' NOT NULL');
        $this->addSql('ALTER TABLE product_category ADD is_active TINYINT(1) DEFAULT \'1\' NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE roles roles JSON NOT NULL, CHANGE firstname firstname VARCHAR(50) DEFAULT NULL, CHANGE surname surname VARCHAR(50) DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(50) DEFAULT NULL, CHANGE postcode postcode VARCHAR(50) DEFAULT NULL, CHANGE mail_addr mail_addr VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP is_active');
        $this->addSql('ALTER TABLE product_category DROP is_active');
        $this->addSql('ALTER TABLE users CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE firstname firstname VARCHAR(50) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci, CHANGE surname surname VARCHAR(50) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci, CHANGE address address VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci, CHANGE phone phone VARCHAR(50) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci, CHANGE postcode postcode VARCHAR(50) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci, CHANGE mail_addr mail_addr VARCHAR(100) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci');
    }
}
