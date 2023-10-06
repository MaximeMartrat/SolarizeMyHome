<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231006214009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profil DROP FOREIGN KEY FK_E6D6B297FB88E14F');
        $this->addSql('DROP TABLE profil');
        $this->addSql('ALTER TABLE calcul DROP FOREIGN KEY FK_B6DD1FA8FB88E14F');
        $this->addSql('DROP INDEX IDX_B6DD1FA8FB88E14F ON calcul');
        $this->addSql('ALTER TABLE calcul DROP utilisateur_id');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3F85E0677 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD calcul_id INT DEFAULT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD facture INT NOT NULL, DROP username, DROP roles, CHANGE password nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3841269A9 FOREIGN KEY (calcul_id) REFERENCES calcul (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3841269A9 ON utilisateur (calcul_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, longueur_toiture DOUBLE PRECISION DEFAULT NULL, largeur_toiture DOUBLE PRECISION DEFAULT NULL, facture INT DEFAULT NULL, INDEX IDX_E6D6B297FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE profil ADD CONSTRAINT FK_E6D6B297FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE calcul ADD utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calcul ADD CONSTRAINT FK_B6DD1FA8FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B6DD1FA8FB88E14F ON calcul (utilisateur_id)');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3841269A9');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3841269A9 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD username VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, DROP calcul_id, DROP nom, DROP prenom, DROP facture');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3F85E0677 ON utilisateur (username)');
    }
}
