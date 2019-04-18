<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190418174852 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE anomalies (id INT AUTO_INCREMENT NOT NULL, type_anomalie_id INT DEFAULT NULL, anomalie VARCHAR(255) NOT NULL, code_anomalie VARCHAR(255) NOT NULL, INDEX IDX_E2C64AC5E5F36606 (type_anomalie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE anomalies_type (id INT AUTO_INCREMENT NOT NULL, anomalie_type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE controles (id INT AUTO_INCREMENT NOT NULL, usages_id INT DEFAULT NULL, verificateur_id INT DEFAULT NULL, centre_id INT DEFAULT NULL, ajouteur_id INT DEFAULT NULL, retireur_id INT DEFAULT NULL, immatriculation VARCHAR(255) NOT NULL, enregistrement VARCHAR(255) NOT NULL, proprietaire VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, anomalies LONGTEXT NOT NULL, date_expiration DATE NOT NULL, papiers_retirers TINYINT(1) NOT NULL, created_at DATE NOT NULL, INDEX IDX_B10ABA6DF78A9799 (usages_id), INDEX IDX_B10ABA6D517E6C75 (verificateur_id), INDEX IDX_B10ABA6D463CD7C3 (centre_id), INDEX IDX_B10ABA6D7268CC77 (ajouteur_id), INDEX IDX_B10ABA6DD226F8C2 (retireur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE controles_anomalies (controles_id INT NOT NULL, anomalies_id INT NOT NULL, INDEX IDX_41CB76C7D8B132DE (controles_id), INDEX IDX_41CB76C789B45173 (anomalies_id), PRIMARY KEY(controles_id, anomalies_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE controles_papiers (controles_id INT NOT NULL, papiers_id INT NOT NULL, INDEX IDX_A0D6FFEED8B132DE (controles_id), INDEX IDX_A0D6FFEED704DEB9 (papiers_id), PRIMARY KEY(controles_id, papiers_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE papiers (id INT AUTO_INCREMENT NOT NULL, papier VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usages (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisations (id INT AUTO_INCREMENT NOT NULL, utilisation VARCHAR(255) NOT NULL, validite SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE anomalies ADD CONSTRAINT FK_E2C64AC5E5F36606 FOREIGN KEY (type_anomalie_id) REFERENCES anomalies_type (id)');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6DF78A9799 FOREIGN KEY (usages_id) REFERENCES utilisations (id)');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6D517E6C75 FOREIGN KEY (verificateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6D463CD7C3 FOREIGN KEY (centre_id) REFERENCES centres (id)');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6D7268CC77 FOREIGN KEY (ajouteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6DD226F8C2 FOREIGN KEY (retireur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE controles_anomalies ADD CONSTRAINT FK_41CB76C7D8B132DE FOREIGN KEY (controles_id) REFERENCES controles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE controles_anomalies ADD CONSTRAINT FK_41CB76C789B45173 FOREIGN KEY (anomalies_id) REFERENCES anomalies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE controles_papiers ADD CONSTRAINT FK_A0D6FFEED8B132DE FOREIGN KEY (controles_id) REFERENCES controles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE controles_papiers ADD CONSTRAINT FK_A0D6FFEED704DEB9 FOREIGN KEY (papiers_id) REFERENCES papiers (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE profession');
        $this->addSql('DROP TABLE province');
        $this->addSql('DROP TABLE role');
        $this->addSql('ALTER TABLE centres ADD numero SMALLINT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE controles_anomalies DROP FOREIGN KEY FK_41CB76C789B45173');
        $this->addSql('ALTER TABLE anomalies DROP FOREIGN KEY FK_E2C64AC5E5F36606');
        $this->addSql('ALTER TABLE controles_anomalies DROP FOREIGN KEY FK_41CB76C7D8B132DE');
        $this->addSql('ALTER TABLE controles_papiers DROP FOREIGN KEY FK_A0D6FFEED8B132DE');
        $this->addSql('ALTER TABLE controles_papiers DROP FOREIGN KEY FK_A0D6FFEED704DEB9');
        $this->addSql('ALTER TABLE controles DROP FOREIGN KEY FK_B10ABA6DF78A9799');
        $this->addSql('CREATE TABLE profession (id INT AUTO_INCREMENT NOT NULL, profession VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE province (id INT AUTO_INCREMENT NOT NULL, province VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE anomalies');
        $this->addSql('DROP TABLE anomalies_type');
        $this->addSql('DROP TABLE controles');
        $this->addSql('DROP TABLE controles_anomalies');
        $this->addSql('DROP TABLE controles_papiers');
        $this->addSql('DROP TABLE papiers');
        $this->addSql('DROP TABLE usages');
        $this->addSql('DROP TABLE utilisations');
        $this->addSql('ALTER TABLE centres DROP numero');
    }
}
