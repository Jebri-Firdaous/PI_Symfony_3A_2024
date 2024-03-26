<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319140209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY billet_ibfk_1');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY billet_ibfk_2');
        $this->addSql('DROP TABLE billet');
        $this->addSql('DROP TABLE station');
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY fk_admin');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT FK_32EB52E85F15257A FOREIGN KEY (id_personne) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY fk_client');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404555F15257A FOREIGN KEY (id_personne) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE commande CHANGE id_personne id_personne INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_article DROP FOREIGN KEY commande_article_ibfk_1');
        $this->addSql('ALTER TABLE commande_article DROP FOREIGN KEY commande_article_ibfk_2');
        $this->addSql('ALTER TABLE commande_article CHANGE id_commande id_commande INT NOT NULL, ADD PRIMARY KEY (id_commande)');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT FK_F4817CC63E314AE8 FOREIGN KEY (id_commande) REFERENCES commande (id_commande)');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT FK_F4817CC6DCA7A716 FOREIGN KEY (id_article) REFERENCES article (id_article)');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY fk_parking');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY fk_user');
        $this->addSql('ALTER TABLE place CHANGE id_parking id_parking INT DEFAULT NULL');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD6CAAFB0A FOREIGN KEY (id_parking) REFERENCES parking (id_parking)');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD6B3CA4B FOREIGN KEY (id_user) REFERENCES client (id_personne)');
        $this->addSql('ALTER TABLE rendez-vous DROP FOREIGN KEY rendez-vous_ibfk_1');
        $this->addSql('ALTER TABLE rendez-vous DROP FOREIGN KEY rendez-vous_ibfk_2');
        $this->addSql('ALTER TABLE rendez-vous CHANGE id_medecin id_medecin INT DEFAULT NULL, CHANGE id_personne id_personne INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rendez-vous ADD CONSTRAINT FK_E6FA19A5C547FAB6 FOREIGN KEY (id_medecin) REFERENCES medecin (id_medecin)');
        $this->addSql('ALTER TABLE rendez-vous ADD CONSTRAINT FK_E6FA19A55F15257A FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY reservation_ibfk_2');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY reservation_ibfk_1');
        $this->addSql('ALTER TABLE reservation CHANGE id_hotel id_hotel INT DEFAULT NULL, CHANGE id_personne id_personne INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849555F15257A FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955EDD61FE9 FOREIGN KEY (id_hotel) REFERENCES hotel (id_hotel)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE billet (ref_voyage INT AUTO_INCREMENT NOT NULL, station INT NOT NULL, id_personne INT NOT NULL, destination_voyage VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_depart DATETIME NOT NULL, prix VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, duree VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX id_station (station), INDEX indexIdPersonne (id_personne), PRIMARY KEY(ref_voyage)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE station (id_station INT AUTO_INCREMENT NOT NULL, nom_station VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, adress_station VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, type VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_station)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT billet_ibfk_1 FOREIGN KEY (station) REFERENCES station (id_station)');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT billet_ibfk_2 FOREIGN KEY (id_personne) REFERENCES client (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY FK_32EB52E85F15257A');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT fk_admin FOREIGN KEY (id_personne) REFERENCES personne (id_personne) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404555F15257A');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT fk_client FOREIGN KEY (id_personne) REFERENCES personne (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande CHANGE id_personne id_personne INT NOT NULL');
        $this->addSql('ALTER TABLE commande_article DROP FOREIGN KEY FK_F4817CC63E314AE8');
        $this->addSql('ALTER TABLE commande_article DROP FOREIGN KEY FK_F4817CC6DCA7A716');
        $this->addSql('DROP INDEX `primary` ON commande_article');
        $this->addSql('ALTER TABLE commande_article CHANGE id_commande id_commande INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT commande_article_ibfk_1 FOREIGN KEY (id_commande) REFERENCES commande (id_commande) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT commande_article_ibfk_2 FOREIGN KEY (id_article) REFERENCES article (id_article) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD6CAAFB0A');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD6B3CA4B');
        $this->addSql('ALTER TABLE place CHANGE id_parking id_parking INT NOT NULL');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT fk_parking FOREIGN KEY (id_parking) REFERENCES parking (id_parking) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT fk_user FOREIGN KEY (id_user) REFERENCES client (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez-vous DROP FOREIGN KEY FK_E6FA19A5C547FAB6');
        $this->addSql('ALTER TABLE rendez-vous DROP FOREIGN KEY FK_E6FA19A55F15257A');
        $this->addSql('ALTER TABLE rendez-vous CHANGE id_medecin id_medecin INT NOT NULL, CHANGE id_personne id_personne INT NOT NULL');
        $this->addSql('ALTER TABLE rendez-vous ADD CONSTRAINT rendez-vous_ibfk_1 FOREIGN KEY (id_medecin) REFERENCES medecin (id_medecin) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez-vous ADD CONSTRAINT rendez-vous_ibfk_2 FOREIGN KEY (id_personne) REFERENCES client (id_personne) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849555F15257A');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955EDD61FE9');
        $this->addSql('ALTER TABLE reservation CHANGE id_personne id_personne INT NOT NULL, CHANGE id_hotel id_hotel INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT reservation_ibfk_2 FOREIGN KEY (id_personne) REFERENCES client (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT reservation_ibfk_1 FOREIGN KEY (id_hotel) REFERENCES hotel (id_hotel) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
