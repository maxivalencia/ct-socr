<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417101423 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE controles CHANGE usages_id usages_id INT DEFAULT NULL, CHANGE verificateur_id verificateur_id INT DEFAULT NULL, CHANGE centre_id centre_id INT DEFAULT NULL, CHANGE ajouteur_id ajouteur_id INT DEFAULT NULL, CHANGE retireur_id retireur_id INT DEFAULT NULL, CHANGE telephone telephone VARCHAR(255) DEFAULT NULL, CHANGE date_retrait date_retrait DATE DEFAULT NULL, CHANGE heure_retrait heure_retrait TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE role_id role_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE anomalies CHANGE type_anomalie_id type_anomalie_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE anomalies CHANGE type_anomalie_id type_anomalie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE controles CHANGE usages_id usages_id INT DEFAULT NULL, CHANGE verificateur_id verificateur_id INT DEFAULT NULL, CHANGE centre_id centre_id INT DEFAULT NULL, CHANGE ajouteur_id ajouteur_id INT DEFAULT NULL, CHANGE retireur_id retireur_id INT DEFAULT NULL, CHANGE telephone telephone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE date_retrait date_retrait DATE DEFAULT \'NULL\', CHANGE heure_retrait heure_retrait TIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE role_id role_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
