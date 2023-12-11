<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231211210132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFE9020683');
        $this->addSql('ALTER TABLE personne_allergene DROP FOREIGN KEY FK_95564DFB4646AB2');
        $this->addSql('ALTER TABLE personne_allergene DROP FOREIGN KEY FK_95564DFBA21BD112');
        $this->addSql('DROP TABLE type_personne');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE personne_allergene');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_personne (id INT AUTO_INCREMENT NOT NULL, nom_tp_pers VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, type_personne_id INT DEFAULT NULL, nom_pers VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, pnom_pers VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, sha512_pass VARCHAR(126) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, pseudo VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo_profil LONGBLOB DEFAULT NULL, date_nais DATE DEFAULT NULL, INDEX IDX_FCEC9EFE9020683 (type_personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE personne_allergene (personne_id INT NOT NULL, allergene_id INT NOT NULL, INDEX IDX_95564DFBA21BD112 (personne_id), INDEX IDX_95564DFB4646AB2 (allergene_id), PRIMARY KEY(personne_id, allergene_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFE9020683 FOREIGN KEY (type_personne_id) REFERENCES type_personne (id)');
        $this->addSql('ALTER TABLE personne_allergene ADD CONSTRAINT FK_95564DFB4646AB2 FOREIGN KEY (allergene_id) REFERENCES allergene (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personne_allergene ADD CONSTRAINT FK_95564DFBA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
    }
}
