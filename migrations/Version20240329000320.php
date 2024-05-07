<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240329000320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY fk_admin');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY station_1');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY user_1');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY commande_ibfk_1');
        $this->addSql('ALTER TABLE commande_article DROP FOREIGN KEY commande_article_ibfk_2');
        $this->addSql('ALTER TABLE commande_article DROP FOREIGN KEY commande_article_ibfk_1');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY reservation_5');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY user_5');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE billet');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_article');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE station');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY fk_client');
        $this->addSql('ALTER TABLE client ADD id INT AUTO_INCREMENT NOT NULL, CHANGE id_personne id_personne INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404555F15257A FOREIGN KEY (id_personne) REFERENCES personne (id_personne)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C74404555F15257A ON client (id_personne)');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A5F15257A');
        $this->addSql('DROP INDEX IDX_65E8AA0A5F15257A ON rendez_vous');
        $this->addSql('ALTER TABLE rendez_vous DROP id_personne, CHANGE ref_rendez_vous ref_rendez_vous VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrateur (id_personne INT AUTO_INCREMENT NOT NULL, role VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_personne)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE article (id_article INT AUTO_INCREMENT NOT NULL, nom_article VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prix_article DOUBLE PRECISION NOT NULL, quantite_article INT NOT NULL, type_article VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description_article VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, photo_article VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_article)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE billet (ref_voyage INT AUTO_INCREMENT NOT NULL, station INT DEFAULT NULL, id_personne INT DEFAULT NULL, destination_voyage VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_depart VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prix VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, duree VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX IDX_1F034AF65F15257A (id_personne), INDEX IDX_1F034AF69F39F8B1 (station), PRIMARY KEY(ref_voyage)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commande (id_commande INT AUTO_INCREMENT NOT NULL, id_personne INT DEFAULT NULL, nombre_article INT NOT NULL, prix_totale VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, delais_commande DATETIME NOT NULL, INDEX IDX_6EEAA67D5F15257A (id_personne), PRIMARY KEY(id_commande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commande_article (id_commande INT NOT NULL, id_article INT NOT NULL, INDEX IDX_F4817CC6DCA7A716 (id_article), INDEX IDX_F4817CC63E314AE8 (id_commande), PRIMARY KEY(id_commande, id_article)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE hotel (id_hotel INT AUTO_INCREMENT NOT NULL, nom_hotel VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, adress_hotel VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prix1 DOUBLE PRECISION NOT NULL, prix2 DOUBLE PRECISION NOT NULL, prix3 DOUBLE PRECISION NOT NULL, numero1 INT NOT NULL, numero2 INT NOT NULL, numero3 INT NOT NULL, PRIMARY KEY(id_hotel)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservation (ref_reservation INT AUTO_INCREMENT NOT NULL, id_hotel INT DEFAULT NULL, id_personne INT DEFAULT NULL, duree_reservation DOUBLE PRECISION NOT NULL, prix_reservation DOUBLE PRECISION NOT NULL, date_reservation DATETIME NOT NULL, type_chambre VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX IDX_42C849555F15257A (id_personne), INDEX IDX_42C84955EDD61FE9 (id_hotel), PRIMARY KEY(ref_reservation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE station (id_station INT AUTO_INCREMENT NOT NULL, nom_station VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, adress_station VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, type VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_station)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT fk_admin FOREIGN KEY (id_personne) REFERENCES personne (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT station_1 FOREIGN KEY (station) REFERENCES station (id_station)');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT user_1 FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT commande_ibfk_1 FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT commande_article_ibfk_2 FOREIGN KEY (id_article) REFERENCES article (id_article)');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT commande_article_ibfk_1 FOREIGN KEY (id_commande) REFERENCES commande (id_commande)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT reservation_5 FOREIGN KEY (id_hotel) REFERENCES hotel (id_hotel)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT user_5 FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
        $this->addSql('ALTER TABLE client MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404555F15257A');
        $this->addSql('DROP INDEX UNIQ_C74404555F15257A ON client');
        $this->addSql('DROP INDEX `PRIMARY` ON client');
        $this->addSql('ALTER TABLE client DROP id, CHANGE id_personne id_personne INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT fk_client FOREIGN KEY (id_personne) REFERENCES personne (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client ADD PRIMARY KEY (id_personne)');
        $this->addSql('ALTER TABLE rendez_vous ADD id_personne INT DEFAULT NULL, CHANGE ref_rendez_vous ref_rendez_vous INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A5F15257A FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A5F15257A ON rendez_vous (id_personne)');
    }
}
