<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417102410 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE controles ADD verificateur_contre_id INT DEFAULT NULL, ADD mise_en_fourriere TINYINT(1) NOT NULL, ADD nom_chauffeur VARCHAR(255) DEFAULT NULL, ADD contact_chauffeur VARCHAR(255) DEFAULT NULL, ADD feuille_de_controle VARCHAR(255) DEFAULT NULL, ADD lieu_de_controle VARCHAR(255) DEFAULT NULL, ADD code VARCHAR(255) DEFAULT NULL, ADD time_created_at TIME DEFAULT NULL, ADD date_debut DATE DEFAULT NULL, CHANGE usages_id usages_id INT DEFAULT NULL, CHANGE verificateur_id verificateur_id INT DEFAULT NULL, CHANGE centre_id centre_id INT DEFAULT NULL, CHANGE ajouteur_id ajouteur_id INT DEFAULT NULL, CHANGE retireur_id retireur_id INT DEFAULT NULL, CHANGE immatriculation immatriculation VARCHAR(255) DEFAULT NULL, CHANGE enregistrement enregistrement VARCHAR(255) DEFAULT NULL, CHANGE proprietaire proprietaire VARCHAR(255) DEFAULT NULL, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL, CHANGE telephone telephone VARCHAR(255) DEFAULT NULL, CHANGE anomalies anomalies LONGTEXT DEFAULT NULL, CHANGE papiers papiers LONGTEXT DEFAULT NULL, CHANGE date_expiration date_expiration DATE DEFAULT NULL, CHANGE date_retrait date_retrait DATE DEFAULT NULL, CHANGE heure_retrait heure_retrait TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6DFCCD9FA1 FOREIGN KEY (verificateur_contre_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B10ABA6DFCCD9FA1 ON controles (verificateur_contre_id)');
        $this->addSql('ALTER TABLE anomalies CHANGE type_anomalie_id type_anomalie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE role_id role_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE anomalies CHANGE type_anomalie_id type_anomalie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE controles DROP FOREIGN KEY FK_B10ABA6DFCCD9FA1');
        $this->addSql('DROP INDEX IDX_B10ABA6DFCCD9FA1 ON controles');
        $this->addSql('ALTER TABLE controles DROP verificateur_contre_id, DROP mise_en_fourriere, DROP nom_chauffeur, DROP contact_chauffeur, DROP feuille_de_controle, DROP lieu_de_controle, DROP code, DROP time_created_at, DROP date_debut, CHANGE usages_id usages_id INT DEFAULT NULL, CHANGE verificateur_id verificateur_id INT DEFAULT NULL, CHANGE centre_id centre_id INT DEFAULT NULL, CHANGE ajouteur_id ajouteur_id INT DEFAULT NULL, CHANGE retireur_id retireur_id INT DEFAULT NULL, CHANGE immatriculation immatriculation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE enregistrement enregistrement VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE proprietaire proprietaire VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE anomalies anomalies LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE papiers papiers LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_expiration date_expiration DATE NOT NULL, CHANGE date_retrait date_retrait DATE DEFAULT \'NULL\', CHANGE heure_retrait heure_retrait TIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE role_id role_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
