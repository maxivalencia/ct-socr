<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190417072249 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE controles (id INT AUTO_INCREMENT NOT NULL, usages_id INT DEFAULT NULL, verificateur_id INT DEFAULT NULL, centre_id INT DEFAULT NULL, immatriculation VARCHAR(255) NOT NULL, enregistrement VARCHAR(255) NOT NULL, proprietaire VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, anomalies LONGTEXT NOT NULL, date_expiration DATE NOT NULL, papiers_retirers TINYINT(1) NOT NULL, created_at DATE NOT NULL, INDEX IDX_B10ABA6DF78A9799 (usages_id), INDEX IDX_B10ABA6D517E6C75 (verificateur_id), INDEX IDX_B10ABA6D463CD7C3 (centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profession (id INT AUTO_INCREMENT NOT NULL, profession VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE province (id INT AUTO_INCREMENT NOT NULL, province VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usages (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6DF78A9799 FOREIGN KEY (usages_id) REFERENCES utilisations (id)');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6D517E6C75 FOREIGN KEY (verificateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6D463CD7C3 FOREIGN KEY (centre_id) REFERENCES centres (id)');
        $this->addSql('DROP TABLE user_test');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_test (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, roles JSON NOT NULL, password VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, profession_id INT NOT NULL, centre_id INT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, date_inscription DATE DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE controles');
        $this->addSql('DROP TABLE profession');
        $this->addSql('DROP TABLE province');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE usages');
    }
}
