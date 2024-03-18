<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318164502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY fk_admin');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY billet_ibfk_1');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY billet_ibfk_2');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY fk_client');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY commande_ibfk_1');
        $this->addSql('ALTER TABLE commande_article DROP FOREIGN KEY commande_article_ibfk_1');
        $this->addSql('ALTER TABLE commande_article DROP FOREIGN KEY commande_article_ibfk_2');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY fk_parking');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY fk_user');
        $this->addSql('ALTER TABLE rendez-vous DROP FOREIGN KEY rendez-vous_ibfk_1');
        $this->addSql('ALTER TABLE rendez-vous DROP FOREIGN KEY rendez-vous_ibfk_2');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY reservation_ibfk_2');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY reservation_ibfk_1');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE billet');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_article');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE parking');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE rendez-vous');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE station');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrateur (id_personne INT NOT NULL, role VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX id_personne (id_personne), PRIMARY KEY(id_personne)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE article (id_article INT AUTO_INCREMENT NOT NULL, nom_article VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prix_article DOUBLE PRECISION NOT NULL, quantite_article INT NOT NULL, type_article VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, description_article TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, photo_article VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_article)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE billet (ref_voyage INT AUTO_INCREMENT NOT NULL, station INT NOT NULL, id_personne INT NOT NULL, destination_voyage VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_depart DATETIME NOT NULL, prix VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, duree VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX id_station (station), INDEX indexIdPersonne (id_personne), PRIMARY KEY(ref_voyage)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE client (id_personne INT NOT NULL, genre VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, age INT NOT NULL, INDEX fk_client (id_personne), INDEX indexIdPersonne (id_personne), PRIMARY KEY(id_personne)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commande (id_commande INT AUTO_INCREMENT NOT NULL, id_personne INT NOT NULL, nombre_article INT NOT NULL, prix_totale NUMERIC(10, 2) NOT NULL, delais_commande DATE NOT NULL, INDEX id_personne (id_personne), PRIMARY KEY(id_commande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commande_article (id_commande INT NOT NULL, id_article INT DEFAULT NULL, INDEX id_commande (id_commande), INDEX id_article (id_article), PRIMARY KEY(id_commande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE hotel (id_hotel INT AUTO_INCREMENT NOT NULL, nom_hotel VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, adress_hotel VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prix1 DOUBLE PRECISION NOT NULL, prix2 DOUBLE PRECISION NOT NULL, prix3 DOUBLE PRECISION NOT NULL, numero1 INT NOT NULL, numero2 INT NOT NULL, numero3 INT NOT NULL, PRIMARY KEY(id_hotel)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE medecin (id_medecin INT AUTO_INCREMENT NOT NULL, nom_medecin VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom_medecin_medecin VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, numero_telephone_medecin INT NOT NULL, address_medecin VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, specialite_medecin VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_medecin)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE parking (id_parking INT AUTO_INCREMENT NOT NULL, nom_parking VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, address_parking VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, nombre_place_max INT NOT NULL, nombre_place_occ INT NOT NULL, etat_parking VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_parking)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE personne (id_personne INT AUTO_INCREMENT NOT NULL, nom_personne VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom_personne VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, numero_telephone INT NOT NULL, mail_personne VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, mdp_personne VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image_personne VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_personne)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE place (ref_place INT AUTO_INCREMENT NOT NULL, id_parking INT NOT NULL, id_user INT DEFAULT NULL, num_place INT NOT NULL, type_place VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, etat VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX fk_user (id_user), INDEX fk_parking (id_parking), PRIMARY KEY(ref_place)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rendez-vous (ref_rendez_vous INT AUTO_INCREMENT NOT NULL, id_medecin INT NOT NULL, id_personne INT NOT NULL, date_rendez_vous DATETIME NOT NULL, INDEX id_personne (id_personne), INDEX id_medecin (id_medecin), PRIMARY KEY(ref_rendez_vous)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservation (ref_reservation INT AUTO_INCREMENT NOT NULL, id_hotel INT NOT NULL, id_personne INT NOT NULL, duree_reservation DOUBLE PRECISION NOT NULL, prix_reservation DOUBLE PRECISION NOT NULL, date_reservation DATE NOT NULL, type_chambre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX id_hotel (id_hotel), INDEX reservation_ibfk_2 (id_personne), PRIMARY KEY(ref_reservation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE station (id_station INT AUTO_INCREMENT NOT NULL, nom_station VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, adress_station VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, type VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_station)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT fk_admin FOREIGN KEY (id_personne) REFERENCES personne (id_personne) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT billet_ibfk_1 FOREIGN KEY (station) REFERENCES station (id_station)');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT billet_ibfk_2 FOREIGN KEY (id_personne) REFERENCES client (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT fk_client FOREIGN KEY (id_personne) REFERENCES personne (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT commande_ibfk_1 FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT commande_article_ibfk_1 FOREIGN KEY (id_commande) REFERENCES commande (id_commande) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT commande_article_ibfk_2 FOREIGN KEY (id_article) REFERENCES article (id_article) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT fk_parking FOREIGN KEY (id_parking) REFERENCES parking (id_parking) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT fk_user FOREIGN KEY (id_user) REFERENCES client (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez-vous ADD CONSTRAINT rendez-vous_ibfk_1 FOREIGN KEY (id_medecin) REFERENCES medecin (id_medecin) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez-vous ADD CONSTRAINT rendez-vous_ibfk_2 FOREIGN KEY (id_personne) REFERENCES client (id_personne) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT reservation_ibfk_2 FOREIGN KEY (id_personne) REFERENCES client (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT reservation_ibfk_1 FOREIGN KEY (id_hotel) REFERENCES hotel (id_hotel) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
