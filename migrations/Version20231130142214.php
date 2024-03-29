<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231130142214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personne_allergene (personne_id INT NOT NULL, allergene_id INT NOT NULL, INDEX IDX_95564DFBA21BD112 (personne_id), INDEX IDX_95564DFB4646AB2 (allergene_id), PRIMARY KEY(personne_id, allergene_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personne_allergene ADD CONSTRAINT FK_95564DFBA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personne_allergene ADD CONSTRAINT FK_95564DFB4646AB2 FOREIGN KEY (allergene_id) REFERENCES allergene (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne_allergene DROP FOREIGN KEY FK_95564DFBA21BD112');
        $this->addSql('ALTER TABLE personne_allergene DROP FOREIGN KEY FK_95564DFB4646AB2');
        $this->addSql('DROP TABLE personne_allergene');
    }
}
