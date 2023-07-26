<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230721062503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD image_name VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD image_name2 VARCHAR(255) DEFAULT NULL, ADD updated_at2 DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD image_name3 VARCHAR(255) DEFAULT NULL, ADD updated_at3 DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP img, DROP img2, DROP img3');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD img VARCHAR(50) DEFAULT NULL, ADD img2 VARCHAR(50) DEFAULT NULL, ADD img3 VARCHAR(50) DEFAULT NULL, DROP image_name, DROP updated_at, DROP image_name2, DROP updated_at2, DROP image_name3, DROP updated_at3');
    }
}
