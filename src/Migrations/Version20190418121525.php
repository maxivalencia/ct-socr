<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190418121525 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE controles_anomalies (controles_id INT NOT NULL, anomalies_id INT NOT NULL, INDEX IDX_41CB76C7D8B132DE (controles_id), INDEX IDX_41CB76C789B45173 (anomalies_id), PRIMARY KEY(controles_id, anomalies_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE controles_papiers (controles_id INT NOT NULL, papiers_id INT NOT NULL, INDEX IDX_A0D6FFEED8B132DE (controles_id), INDEX IDX_A0D6FFEED704DEB9 (papiers_id), PRIMARY KEY(controles_id, papiers_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE controles_anomalies ADD CONSTRAINT FK_41CB76C7D8B132DE FOREIGN KEY (controles_id) REFERENCES controles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE controles_anomalies ADD CONSTRAINT FK_41CB76C789B45173 FOREIGN KEY (anomalies_id) REFERENCES anomalies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE controles_papiers ADD CONSTRAINT FK_A0D6FFEED8B132DE FOREIGN KEY (controles_id) REFERENCES controles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE controles_papiers ADD CONSTRAINT FK_A0D6FFEED704DEB9 FOREIGN KEY (papiers_id) REFERENCES papiers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE controles ADD ajouteur_id INT DEFAULT NULL, ADD retireur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6D7268CC77 FOREIGN KEY (ajouteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE controles ADD CONSTRAINT FK_B10ABA6DD226F8C2 FOREIGN KEY (retireur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B10ABA6D7268CC77 ON controles (ajouteur_id)');
        $this->addSql('CREATE INDEX IDX_B10ABA6DD226F8C2 ON controles (retireur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE controles_anomalies');
        $this->addSql('DROP TABLE controles_papiers');
        $this->addSql('ALTER TABLE controles DROP FOREIGN KEY FK_B10ABA6D7268CC77');
        $this->addSql('ALTER TABLE controles DROP FOREIGN KEY FK_B10ABA6DD226F8C2');
        $this->addSql('DROP INDEX IDX_B10ABA6D7268CC77 ON controles');
        $this->addSql('DROP INDEX IDX_B10ABA6DD226F8C2 ON controles');
        $this->addSql('ALTER TABLE controles DROP ajouteur_id, DROP retireur_id');
    }
}
