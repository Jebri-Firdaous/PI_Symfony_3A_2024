<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328041703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rendez_vous (ref_rendez_vous VARCHAR(255) NOT NULL, id_medecin INT DEFAULT NULL, id_personne INT DEFAULT NULL, date_rendez_vous DATETIME NOT NULL, INDEX IDX_65E8AA0AC547FAB6 (id_medecin), INDEX IDX_65E8AA0A5F15257A (id_personne), PRIMARY KEY(ref_rendez_vous)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AC547FAB6 FOREIGN KEY (id_medecin) REFERENCES medecin (id_medecin)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A5F15257A FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY fk_user');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY fk_parking');
        $this->addSql('ALTER TABLE rendez-vous DROP FOREIGN KEY rendez-vous_ibfk_1');
        $this->addSql('ALTER TABLE rendez-vous DROP FOREIGN KEY rendez-vous_ibfk_2');
        $this->addSql('DROP TABLE parking');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE rendez-vous');
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY fk_admin');
        $this->addSql('DROP INDEX id_personne ON administrateur');
        $this->addSql('ALTER TABLE administrateur ADD nom_personne VARCHAR(30) NOT NULL, ADD prenom_personne VARCHAR(30) NOT NULL, ADD numero_telephone INT NOT NULL, ADD mail_personne VARCHAR(50) NOT NULL, ADD mdp_personne VARCHAR(50) NOT NULL, ADD image_personne VARCHAR(255) NOT NULL, CHANGE id_personne id_personne INT AUTO_INCREMENT NOT NULL, CHANGE role role VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE article CHANGE type_article type_article VARCHAR(255) NOT NULL, CHANGE description_article description_article VARCHAR(255) NOT NULL, CHANGE photo_article photo_article VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY billet_ibfk_2');
        $this->addSql('ALTER TABLE billet CHANGE station station INT DEFAULT NULL, CHANGE id_personne id_personne INT DEFAULT NULL, CHANGE date_depart date_depart VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF65F15257A FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
        $this->addSql('ALTER TABLE billet RENAME INDEX id_station TO IDX_1F034AF69F39F8B1');
        $this->addSql('ALTER TABLE billet RENAME INDEX indexidpersonne TO IDX_1F034AF65F15257A');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY fk_client');
        $this->addSql('DROP INDEX fk_client ON client');
        $this->addSql('DROP INDEX indexIdPersonne ON client');
        $this->addSql('ALTER TABLE client ADD nom_personne VARCHAR(30) NOT NULL, ADD prenom_personne VARCHAR(30) NOT NULL, ADD numero_telephone INT NOT NULL, ADD mail_personne VARCHAR(50) NOT NULL, ADD mdp_personne VARCHAR(50) NOT NULL, ADD image_personne VARCHAR(255) NOT NULL, CHANGE id_personne id_personne INT AUTO_INCREMENT NOT NULL, CHANGE genre genre VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE commande CHANGE id_personne id_personne INT DEFAULT NULL, CHANGE prix_totale prix_totale VARCHAR(10) NOT NULL, CHANGE delais_commande delais_commande DATETIME NOT NULL');
        $this->addSql('ALTER TABLE commande RENAME INDEX id_personne TO IDX_6EEAA67D5F15257A');
        $this->addSql('ALTER TABLE commande_article DROP FOREIGN KEY commande_article_ibfk_1');
        $this->addSql('ALTER TABLE commande_article DROP FOREIGN KEY commande_article_ibfk_2');
        $this->addSql('ALTER TABLE commande_article CHANGE id_commande id_commande INT NOT NULL, CHANGE id_article id_article INT NOT NULL, ADD PRIMARY KEY (id_commande, id_article)');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT FK_F4817CC63E314AE8 FOREIGN KEY (id_commande) REFERENCES commande (id_commande)');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT FK_F4817CC6DCA7A716 FOREIGN KEY (id_article) REFERENCES article (id_article)');
        $this->addSql('ALTER TABLE commande_article RENAME INDEX id_commande TO IDX_F4817CC63E314AE8');
        $this->addSql('ALTER TABLE commande_article RENAME INDEX id_article TO IDX_F4817CC6DCA7A716');
        $this->addSql('ALTER TABLE hotel CHANGE nom_hotel nom_hotel VARCHAR(15) NOT NULL, CHANGE adress_hotel adress_hotel VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY reservation_ibfk_1');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY reservation_ibfk_2');
        $this->addSql('ALTER TABLE reservation CHANGE id_hotel id_hotel INT DEFAULT NULL, CHANGE id_personne id_personne INT DEFAULT NULL, CHANGE date_reservation date_reservation DATETIME NOT NULL, CHANGE type_chambre type_chambre VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849555F15257A FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955EDD61FE9 FOREIGN KEY (id_hotel) REFERENCES hotel (id_hotel)');
        $this->addSql('ALTER TABLE reservation RENAME INDEX reservation_ibfk_2 TO IDX_42C849555F15257A');
        $this->addSql('ALTER TABLE reservation RENAME INDEX id_hotel TO IDX_42C84955EDD61FE9');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parking (id_parking INT AUTO_INCREMENT NOT NULL, nom_parking VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, address_parking VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, nombre_place_max INT NOT NULL, nombre_place_occ INT NOT NULL, etat_parking VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_parking)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE place (ref_place INT AUTO_INCREMENT NOT NULL, id_parking INT NOT NULL, id_user INT DEFAULT NULL, num_place INT NOT NULL, type_place VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, etat VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX fk_parking (id_parking), INDEX fk_user (id_user), PRIMARY KEY(ref_place)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rendez-vous (ref_rendez_vous INT AUTO_INCREMENT NOT NULL, id_medecin INT NOT NULL, id_personne INT NOT NULL, date_rendez_vous DATETIME NOT NULL, INDEX id_personne (id_personne), INDEX id_medecin (id_medecin), PRIMARY KEY(ref_rendez_vous)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT fk_user FOREIGN KEY (id_user) REFERENCES client (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT fk_parking FOREIGN KEY (id_parking) REFERENCES parking (id_parking) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez-vous ADD CONSTRAINT rendez-vous_ibfk_1 FOREIGN KEY (id_medecin) REFERENCES medecin (id_medecin) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez-vous ADD CONSTRAINT rendez-vous_ibfk_2 FOREIGN KEY (id_personne) REFERENCES client (id_personne) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AC547FAB6');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A5F15257A');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE administrateur DROP nom_personne, DROP prenom_personne, DROP numero_telephone, DROP mail_personne, DROP mdp_personne, DROP image_personne, CHANGE id_personne id_personne INT NOT NULL, CHANGE role role VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT fk_admin FOREIGN KEY (id_personne) REFERENCES personne (id_personne) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX id_personne ON administrateur (id_personne)');
        $this->addSql('ALTER TABLE article CHANGE type_article type_article VARCHAR(255) DEFAULT NULL, CHANGE description_article description_article TEXT DEFAULT NULL, CHANGE photo_article photo_article VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF65F15257A');
        $this->addSql('ALTER TABLE billet CHANGE station station INT NOT NULL, CHANGE id_personne id_personne INT NOT NULL, CHANGE date_depart date_depart DATETIME NOT NULL');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT billet_ibfk_2 FOREIGN KEY (id_personne) REFERENCES client (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billet RENAME INDEX idx_1f034af69f39f8b1 TO id_station');
        $this->addSql('ALTER TABLE billet RENAME INDEX idx_1f034af65f15257a TO indexIdPersonne');
        $this->addSql('ALTER TABLE client DROP nom_personne, DROP prenom_personne, DROP numero_telephone, DROP mail_personne, DROP mdp_personne, DROP image_personne, CHANGE id_personne id_personne INT NOT NULL, CHANGE genre genre VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT fk_client FOREIGN KEY (id_personne) REFERENCES personne (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX fk_client ON client (id_personne)');
        $this->addSql('CREATE INDEX indexIdPersonne ON client (id_personne)');
        $this->addSql('ALTER TABLE commande CHANGE id_personne id_personne INT NOT NULL, CHANGE prix_totale prix_totale NUMERIC(10, 2) NOT NULL, CHANGE delais_commande delais_commande DATE NOT NULL');
        $this->addSql('ALTER TABLE commande RENAME INDEX idx_6eeaa67d5f15257a TO id_personne');
        $this->addSql('ALTER TABLE commande_article DROP FOREIGN KEY FK_F4817CC63E314AE8');
        $this->addSql('ALTER TABLE commande_article DROP FOREIGN KEY FK_F4817CC6DCA7A716');
        $this->addSql('DROP INDEX `primary` ON commande_article');
        $this->addSql('ALTER TABLE commande_article CHANGE id_commande id_commande INT DEFAULT NULL, CHANGE id_article id_article INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT commande_article_ibfk_1 FOREIGN KEY (id_commande) REFERENCES commande (id_commande) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT commande_article_ibfk_2 FOREIGN KEY (id_article) REFERENCES article (id_article) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_article RENAME INDEX idx_f4817cc6dca7a716 TO id_article');
        $this->addSql('ALTER TABLE commande_article RENAME INDEX idx_f4817cc63e314ae8 TO id_commande');
        $this->addSql('ALTER TABLE hotel CHANGE nom_hotel nom_hotel VARCHAR(30) NOT NULL, CHANGE adress_hotel adress_hotel VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849555F15257A');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955EDD61FE9');
        $this->addSql('ALTER TABLE reservation CHANGE id_personne id_personne INT NOT NULL, CHANGE id_hotel id_hotel INT NOT NULL, CHANGE date_reservation date_reservation DATE NOT NULL, CHANGE type_chambre type_chambre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT reservation_ibfk_1 FOREIGN KEY (id_hotel) REFERENCES hotel (id_hotel) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT reservation_ibfk_2 FOREIGN KEY (id_personne) REFERENCES client (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation RENAME INDEX idx_42c849555f15257a TO reservation_ibfk_2');
        $this->addSql('ALTER TABLE reservation RENAME INDEX idx_42c84955edd61fe9 TO id_hotel');
    }
}
