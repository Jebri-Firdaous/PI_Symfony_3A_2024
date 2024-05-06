<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430183852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrateur (id_personne INT NOT NULL, role VARCHAR(30) NOT NULL, PRIMARY KEY(id_personne)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id_personne INT NOT NULL, genre VARCHAR(30) NOT NULL, age INT NOT NULL, PRIMARY KEY(id_personne)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medecin (id_medecin INT AUTO_INCREMENT NOT NULL, nom_medecin VARCHAR(30) NOT NULL, prenom_medecin_medecin VARCHAR(30) NOT NULL, numero_telephone_medecin INT NOT NULL, address_medecin VARCHAR(50) NOT NULL, specialite_medecin VARCHAR(50) NOT NULL, PRIMARY KEY(id_medecin)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id_personne INT AUTO_INCREMENT NOT NULL, nom_personne VARCHAR(30) DEFAULT NULL, prenom_personne VARCHAR(30) NOT NULL, numero_telephone INT NOT NULL, email VARCHAR(50) NOT NULL, mdp_personne VARCHAR(50) NOT NULL, image_personne VARCHAR(255) NOT NULL, PRIMARY KEY(id_personne)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (ref_rendez_vous VARCHAR(255) NOT NULL, id_personne INT DEFAULT NULL, id_medecin INT DEFAULT NULL, date_rendez_vous DATETIME NOT NULL, INDEX IDX_65E8AA0A5F15257A (id_personne), INDEX IDX_65E8AA0AC547FAB6 (id_medecin), PRIMARY KEY(ref_rendez_vous)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT FK_32EB52E85F15257A FOREIGN KEY (id_personne) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404555F15257A FOREIGN KEY (id_personne) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A5F15257A FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AC547FAB6 FOREIGN KEY (id_medecin) REFERENCES medecin (id_medecin)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY FK_32EB52E85F15257A');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404555F15257A');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A5F15257A');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AC547FAB6');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
