<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191104111422 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE controles (id INT AUTO_INCREMENT NOT NULL, usages_id INT DEFAULT NULL, verificateur_id INT DEFAULT NULL, centre_id INT DEFAULT NULL, ajouteur_id INT DEFAULT NULL, retireur_id INT DEFAULT NULL, immatriculation VARCHAR(255) NOT NULL, enregistrement VARCHAR(255) NOT NULL, proprietaire VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, anomalies LONGTEXT NOT NULL, papiers LONGTEXT NOT NULL, date_expiration DATE NOT NULL, papiers_retirers TINYINT(1) NOT NULL, created_at DATE NOT NULL, date_retrait DATE DEFAULT NULL, heure_retrait TIME DEFAULT NULL, INDEX IDX_B10ABA6DF78A9799 (usages_id), INDEX IDX_B10ABA6D517E6C75 (verificateur_id), INDEX IDX_B10ABA6D463CD7C3 (centre_id), INDEX IDX_B10ABA6D7268CC77 (ajouteur_id), INDEX IDX_B10ABA6DD226F8C2 (retireur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thread_anomalies (controles_id INT NOT NULL, anomalies_id INT NOT NULL, INDEX IDX_6DAC6579D8B132DE (controles_id), INDEX IDX_6DAC657989B45173 (anomalies_id), PRIMARY KEY(controles_id, anomalies_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thread_papiers (controles_id INT NOT NULL, papiers_id INT NOT NULL, INDEX IDX_26F3519CD8B132DE (controles_id), INDEX IDX_26F3519CD704DEB9 (papiers_id), PRIMARY KEY(controles_id, papiers_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thread_anom (controles_id INT NOT NULL, anomalies_id INT NOT NULL, INDEX IDX_B540DF53D8B132DE (controles_id), INDEX IDX_B540DF5389B45173 (anomalies_id), PRIMARY KEY(controles_id, anomalies_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thread_pap (controles_id INT NOT NULL, papiers_id INT NOT NULL, INDEX IDX_880ECA8BD8B132DE (controles_id), INDEX IDX_880ECA8BD704DEB9 (papiers_id), PRIMARY KEY(controles_id, papiers_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE anomalies (id INT AUTO_INCREMENT NOT NULL, type_anomalie_id INT DEFAULT NULL, anomalie VARCHAR(255) NOT NULL, code_anomalie VARCHAR(255) NOT NULL, INDEX IDX_E2C64AC5E5F36606 (type_anomalie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE anomalies_type (id INT AUTO_INCREMENT NOT NULL, anomalie_type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bundle_controles (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centres (id INT AUTO_INCREMENT NOT NULL, province_id INT NOT NULL, centre VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, numero SMALLINT NOT NULL, INDEX IDX_3BA7EA52E946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE papiers (id INT AUTO_INCREMENT NOT NULL, papier VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professions (id INT AUTO_INCREMENT NOT NULL, profession VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE provinces (id INT AUTO_INCREMENT NOT NULL, province VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usages (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, profession_id INT NOT NULL, centre_id INT NOT NULL, role_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_inscription DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649FDEF8996 (profession_id), INDEX IDX_8D93D649463CD7C3 (centre_id), INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisations (id INT AUTO_INCREMENT NOT NULL, utilisation VARCHAR(255) NOT NULL, validite SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6DF78A9799 FOREIGN KEY (usages_id) REFERENCES utilisations (id)');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6D517E6C75 FOREIGN KEY (verificateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6D463CD7C3 FOREIGN KEY (centre_id) REFERENCES centres (id)');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6D7268CC77 FOREIGN KEY (ajouteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6DD226F8C2 FOREIGN KEY (retireur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE thread_anomalies ADD CONSTRAINT FK_6DAC6579D8B132DE FOREIGN KEY (controles_id) REFERENCES controles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thread_anomalies ADD CONSTRAINT FK_6DAC657989B45173 FOREIGN KEY (anomalies_id) REFERENCES anomalies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thread_papiers ADD CONSTRAINT FK_26F3519CD8B132DE FOREIGN KEY (controles_id) REFERENCES controles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thread_papiers ADD CONSTRAINT FK_26F3519CD704DEB9 FOREIGN KEY (papiers_id) REFERENCES papiers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thread_anom ADD CONSTRAINT FK_B540DF53D8B132DE FOREIGN KEY (controles_id) REFERENCES controles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thread_anom ADD CONSTRAINT FK_B540DF5389B45173 FOREIGN KEY (anomalies_id) REFERENCES anomalies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thread_pap ADD CONSTRAINT FK_880ECA8BD8B132DE FOREIGN KEY (controles_id) REFERENCES controles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thread_pap ADD CONSTRAINT FK_880ECA8BD704DEB9 FOREIGN KEY (papiers_id) REFERENCES papiers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anomalies ADD CONSTRAINT FK_E2C64AC5E5F36606 FOREIGN KEY (type_anomalie_id) REFERENCES anomalies_type (id)');
        $this->addSql('ALTER TABLE centres ADD CONSTRAINT FK_3BA7EA52E946114A FOREIGN KEY (province_id) REFERENCES provinces (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FDEF8996 FOREIGN KEY (profession_id) REFERENCES professions (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649463CD7C3 FOREIGN KEY (centre_id) REFERENCES centres (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE thread_anomalies DROP FOREIGN KEY FK_6DAC6579D8B132DE');
        $this->addSql('ALTER TABLE thread_papiers DROP FOREIGN KEY FK_26F3519CD8B132DE');
        $this->addSql('ALTER TABLE thread_anom DROP FOREIGN KEY FK_B540DF53D8B132DE');
        $this->addSql('ALTER TABLE thread_pap DROP FOREIGN KEY FK_880ECA8BD8B132DE');
        $this->addSql('ALTER TABLE thread_anomalies DROP FOREIGN KEY FK_6DAC657989B45173');
        $this->addSql('ALTER TABLE thread_anom DROP FOREIGN KEY FK_B540DF5389B45173');
        $this->addSql('ALTER TABLE anomalies DROP FOREIGN KEY FK_E2C64AC5E5F36606');
        $this->addSql('ALTER TABLE controles DROP FOREIGN KEY FK_B10ABA6D463CD7C3');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649463CD7C3');
        $this->addSql('ALTER TABLE thread_papiers DROP FOREIGN KEY FK_26F3519CD704DEB9');
        $this->addSql('ALTER TABLE thread_pap DROP FOREIGN KEY FK_880ECA8BD704DEB9');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FDEF8996');
        $this->addSql('ALTER TABLE centres DROP FOREIGN KEY FK_3BA7EA52E946114A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE controles DROP FOREIGN KEY FK_B10ABA6D517E6C75');
        $this->addSql('ALTER TABLE controles DROP FOREIGN KEY FK_B10ABA6D7268CC77');
        $this->addSql('ALTER TABLE controles DROP FOREIGN KEY FK_B10ABA6DD226F8C2');
        $this->addSql('ALTER TABLE controles DROP FOREIGN KEY FK_B10ABA6DF78A9799');
        $this->addSql('DROP TABLE controles');
        $this->addSql('DROP TABLE thread_anomalies');
        $this->addSql('DROP TABLE thread_papiers');
        $this->addSql('DROP TABLE thread_anom');
        $this->addSql('DROP TABLE thread_pap');
        $this->addSql('DROP TABLE anomalies');
        $this->addSql('DROP TABLE anomalies_type');
        $this->addSql('DROP TABLE bundle_controles');
        $this->addSql('DROP TABLE centres');
        $this->addSql('DROP TABLE papiers');
        $this->addSql('DROP TABLE professions');
        $this->addSql('DROP TABLE provinces');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE usages');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE utilisations');
    }
}
