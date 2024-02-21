<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240209222748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car_picture (car_id INT NOT NULL, picture_id INT NOT NULL, INDEX IDX_4570B455C3C6F69F (car_id), INDEX IDX_4570B455EE45BDBF (picture_id), PRIMARY KEY(car_id, picture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_picture ADD CONSTRAINT FK_4570B455C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_picture ADD CONSTRAINT FK_4570B455EE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car_picture DROP FOREIGN KEY FK_4570B455C3C6F69F');
        $this->addSql('ALTER TABLE car_picture DROP FOREIGN KEY FK_4570B455EE45BDBF');
        $this->addSql('DROP TABLE car_picture');
    }
}
