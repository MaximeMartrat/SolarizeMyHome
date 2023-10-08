<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231008133343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1D1C63B3F85E0677 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP username, DROP roles, DROP password, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE longueur_toit longueur_toit DOUBLE PRECISION NOT NULL, CHANGE largeur_toit largeur_toit DOUBLE PRECISION NOT NULL, CHANGE facture facture INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD username VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL, CHANGE longueur_toit longueur_toit DOUBLE PRECISION DEFAULT NULL, CHANGE largeur_toit largeur_toit DOUBLE PRECISION DEFAULT NULL, CHANGE facture facture INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3F85E0677 ON utilisateur (username)');
    }
}
