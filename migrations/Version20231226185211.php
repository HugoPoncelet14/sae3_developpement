<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231226185211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recette_ustensile (recette_id INT NOT NULL, ustensile_id INT NOT NULL, INDEX IDX_613487D589312FE9 (recette_id), INDEX IDX_613487D5B78A4282 (ustensile_id), PRIMARY KEY(recette_id, ustensile_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ustensile (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, img_rec LONGBLOB DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recette_ustensile ADD CONSTRAINT FK_613487D589312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_ustensile ADD CONSTRAINT FK_613487D5B78A4282 FOREIGN KEY (ustensile_id) REFERENCES ustensile (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette_ustensile DROP FOREIGN KEY FK_613487D589312FE9');
        $this->addSql('ALTER TABLE recette_ustensile DROP FOREIGN KEY FK_613487D5B78A4282');
        $this->addSql('DROP TABLE recette_ustensile');
        $this->addSql('DROP TABLE ustensile');
    }
}
