<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231127204924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne ADD type_personne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFE9020683 FOREIGN KEY (type_personne_id) REFERENCES type_personne (id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EFE9020683 ON personne (type_personne_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFE9020683');
        $this->addSql('DROP INDEX IDX_FCEC9EFE9020683 ON personne');
        $this->addSql('ALTER TABLE personne DROP type_personne_id');
    }
}
