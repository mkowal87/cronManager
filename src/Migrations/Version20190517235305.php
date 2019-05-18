<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190517235305 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product CHANGE product_name product_name VARCHAR(255) DEFAULT NULL, CHANGE product_url product_url VARCHAR(255) DEFAULT NULL, CHANGE product_image product_image VARCHAR(255) DEFAULT NULL, CHANGE product_price product_price VARCHAR(255) DEFAULT NULL, CHANGE product_currency product_currency VARCHAR(255) DEFAULT NULL, CHANGE product_description product_description VARCHAR(255) DEFAULT NULL, CHANGE product_color product_color VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_size ADD product_id VARCHAR(255) DEFAULT NULL, ADD product_status VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product CHANGE product_name product_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE product_url product_url VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE product_image product_image VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE product_price product_price VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE product_currency product_currency VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE product_description product_description VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE product_color product_color VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE product_size DROP product_id, DROP product_status');
    }
}
