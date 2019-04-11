<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190411103729 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE profession (id INT AUTO_INCREMENT NOT NULL, profession VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE province (id INT AUTO_INCREMENT NOT NULL, province VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE centres ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE centres ADD CONSTRAINT FK_3BA7EA52A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3BA7EA52A76ED395 ON centres (user_id)');
        $this->addSql('ALTER TABLE professions ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE professions ADD CONSTRAINT FK_2FDA85FAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2FDA85FAA76ED395 ON professions (user_id)');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD date_inscription DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE profession');
        $this->addSql('DROP TABLE province');
        $this->addSql('DROP TABLE role');
        $this->addSql('ALTER TABLE centres DROP FOREIGN KEY FK_3BA7EA52A76ED395');
        $this->addSql('DROP INDEX IDX_3BA7EA52A76ED395 ON centres');
        $this->addSql('ALTER TABLE centres DROP user_id');
        $this->addSql('ALTER TABLE professions DROP FOREIGN KEY FK_2FDA85FAA76ED395');
        $this->addSql('DROP INDEX IDX_2FDA85FAA76ED395 ON professions');
        $this->addSql('ALTER TABLE professions DROP user_id');
        $this->addSql('ALTER TABLE user DROP nom, DROP prenom, DROP date_inscription');
    }
}
