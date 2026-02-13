<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213145513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ban (id INT AUTO_INCREMENT NOT NULL, user_cible VARCHAR(255) NOT NULL, raison VARCHAR(255) NOT NULL, date_fin DATETIME NOT NULL, is_active TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE fraction (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, power VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE inventory_item (id INT AUTO_INCREMENT NOT NULL, quantity INT NOT NULL, user_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_55BDEA30A76ED395 (user_id), INDEX IDX_55BDEA30126F525E (item_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, prix VARCHAR(255) NOT NULL, rarete VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL, password VARCHAR(255) NOT NULL, pseudo_minecraft VARCHAR(255) NOT NULL, uuid_minecraft VARCHAR(255) NOT NULL, credits INT NOT NULL, date_inscription DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE inventory_item ADD CONSTRAINT FK_55BDEA30A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inventory_item ADD CONSTRAINT FK_55BDEA30126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventory_item DROP FOREIGN KEY FK_55BDEA30A76ED395');
        $this->addSql('ALTER TABLE inventory_item DROP FOREIGN KEY FK_55BDEA30126F525E');
        $this->addSql('DROP TABLE ban');
        $this->addSql('DROP TABLE fraction');
        $this->addSql('DROP TABLE inventory_item');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
