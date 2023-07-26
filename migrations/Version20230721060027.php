<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230721060027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_has_product (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, orderr_id INT NOT NULL, token VARCHAR(255) NOT NULL, quantity INT NOT NULL, INDEX IDX_AF0913F04584665A (product_id), INDEX IDX_AF0913F07742FDB3 (orderr_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_has_product ADD CONSTRAINT FK_AF0913F04584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_has_product ADD CONSTRAINT FK_AF0913F07742FDB3 FOREIGN KEY (orderr_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE `order` ADD token VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product ADD tva DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_has_product DROP FOREIGN KEY FK_AF0913F04584665A');
        $this->addSql('ALTER TABLE order_has_product DROP FOREIGN KEY FK_AF0913F07742FDB3');
        $this->addSql('DROP TABLE order_has_product');
        $this->addSql('ALTER TABLE `order` DROP token');
        $this->addSql('ALTER TABLE product DROP tva');
    }
}
