<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231130162816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantite ADD ingrediant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quantite ADD CONSTRAINT FK_8BF24A798AEA29A FOREIGN KEY (ingrediant_id) REFERENCES ingrediant (id)');
        $this->addSql('CREATE INDEX IDX_8BF24A798AEA29A ON quantite (ingrediant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantite DROP FOREIGN KEY FK_8BF24A798AEA29A');
        $this->addSql('DROP INDEX IDX_8BF24A798AEA29A ON quantite');
        $this->addSql('ALTER TABLE quantite DROP ingrediant_id');
    }
}
