<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231130154350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingrediant ADD allergene_id INT NOT NULL');
        $this->addSql('ALTER TABLE ingrediant ADD CONSTRAINT FK_6CA6D0AC4646AB2 FOREIGN KEY (allergene_id) REFERENCES allergene (id)');
        $this->addSql('CREATE INDEX IDX_6CA6D0AC4646AB2 ON ingrediant (allergene_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingrediant DROP FOREIGN KEY FK_6CA6D0AC4646AB2');
        $this->addSql('DROP INDEX IDX_6CA6D0AC4646AB2 ON ingrediant');
        $this->addSql('ALTER TABLE ingrediant DROP allergene_id');
    }
}
