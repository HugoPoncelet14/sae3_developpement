<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204175542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pays ADD region_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pays ADD CONSTRAINT FK_349F3CAE98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_349F3CAE98260155 ON pays (region_id)');
        $this->addSql('ALTER TABLE region DROP FOREIGN KEY FK_F62F176A6E44244');
        $this->addSql('DROP INDEX IDX_F62F176A6E44244 ON region');
        $this->addSql('ALTER TABLE region DROP pays_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pays DROP FOREIGN KEY FK_349F3CAE98260155');
        $this->addSql('DROP INDEX IDX_349F3CAE98260155 ON pays');
        $this->addSql('ALTER TABLE pays DROP region_id');
        $this->addSql('ALTER TABLE region ADD pays_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE region ADD CONSTRAINT FK_F62F176A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('CREATE INDEX IDX_F62F176A6E44244 ON region (pays_id)');
    }
}
