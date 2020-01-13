<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200101235532 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, jour_de_visite DATE NOT NULL, type_de_billet TINYINT(1) NOT NULL, quantite INT NOT NULL, e_mail VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visitor (id INT AUTO_INCREMENT NOT NULL, booking_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, date_de_naissance DATE NOT NULL, tarif_reduit TINYINT(1) NOT NULL, INDEX IDX_CAE5E19F3301C60 (booking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE visitor ADD CONSTRAINT FK_CAE5E19F3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE visitor DROP FOREIGN KEY FK_CAE5E19F3301C60');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE visitor');
    }
}
