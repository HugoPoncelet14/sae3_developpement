<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240106145840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantite DROP FOREIGN KEY FK_8BF24A798AEA29A');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, allergene_id INT DEFAULT NULL, nom_ing VARCHAR(50) NOT NULL, img_ing LONGBLOB DEFAULT NULL, INDEX IDX_6BAF78704646AB2 (allergene_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF78704646AB2 FOREIGN KEY (allergene_id) REFERENCES allergene (id)');
        $this->addSql('ALTER TABLE ingrediant DROP FOREIGN KEY FK_6CA6D0AC4646AB2');
        $this->addSql('DROP TABLE ingrediant');
        $this->addSql('DROP INDEX IDX_8BF24A798AEA29A ON quantite');
        $this->addSql('ALTER TABLE quantite CHANGE ingrediant_id ingredient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quantite ADD CONSTRAINT FK_8BF24A79933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('CREATE INDEX IDX_8BF24A79933FE08C ON quantite (ingredient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantite DROP FOREIGN KEY FK_8BF24A79933FE08C');
        $this->addSql('CREATE TABLE ingrediant (id INT AUTO_INCREMENT NOT NULL, allergene_id INT DEFAULT NULL, nom_ing VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, img_ing LONGBLOB DEFAULT NULL, INDEX IDX_6CA6D0AC4646AB2 (allergene_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ingrediant ADD CONSTRAINT FK_6CA6D0AC4646AB2 FOREIGN KEY (allergene_id) REFERENCES allergene (id)');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF78704646AB2');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP INDEX IDX_8BF24A79933FE08C ON quantite');
        $this->addSql('ALTER TABLE quantite CHANGE ingredient_id ingrediant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quantite ADD CONSTRAINT FK_8BF24A798AEA29A FOREIGN KEY (ingrediant_id) REFERENCES ingrediant (id)');
        $this->addSql('CREATE INDEX IDX_8BF24A798AEA29A ON quantite (ingrediant_id)');
    }
}
