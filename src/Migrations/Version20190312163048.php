<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190312163048 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE visitor ADD booking_id INT NOT NULL');
        $this->addSql('ALTER TABLE visitor ADD CONSTRAINT FK_CAE5E19F3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_CAE5E19F3301C60 ON visitor (booking_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE visitor DROP FOREIGN KEY FK_CAE5E19F3301C60');
        $this->addSql('DROP INDEX IDX_CAE5E19F3301C60 ON visitor');
        $this->addSql('ALTER TABLE visitor DROP booking_id');
    }
}
