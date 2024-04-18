<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417101905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez-vous DROP FOREIGN KEY rendez-vous_ibfk_1');
        $this->addSql('ALTER TABLE rendez-vous DROP FOREIGN KEY rendez-vous_ibfk_2');
        $this->addSql('DROP TABLE rendez-vous');
        $this->addSql('ALTER TABLE billet RENAME INDEX id_station TO IDX_1F034AF69F39F8B1');
        $this->addSql('ALTER TABLE billet RENAME INDEX indexidpersonne TO IDX_1F034AF65F15257A');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY fk_client');
        $this->addSql('DROP INDEX indexIdPersonne ON client');
        $this->addSql('DROP INDEX fk_client ON client');
        $this->addSql('ALTER TABLE client ADD nom_personne VARCHAR(30) NOT NULL, ADD prenom_personne VARCHAR(30) NOT NULL, ADD numero_telephone INT NOT NULL, ADD mail_personne VARCHAR(50) NOT NULL, ADD mdp_personne VARCHAR(50) NOT NULL, ADD image_personne VARCHAR(255) NOT NULL, CHANGE id_personne id_personne INT AUTO_INCREMENT NOT NULL, CHANGE genre genre VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE commande ADD id_personne INT DEFAULT NULL, CHANGE prix_totale prix_totale VARCHAR(10) NOT NULL, CHANGE delais_commande delais_commande DATETIME NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D5F15257A FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D5F15257A ON commande (id_personne)');
        $this->addSql('ALTER TABLE commande_article CHANGE id_commande id_commande INT NOT NULL, CHANGE id_article id_article INT NOT NULL, ADD PRIMARY KEY (id_commande, id_article)');
        $this->addSql('ALTER TABLE commande_article RENAME INDEX id_commande TO IDX_F4817CC63E314AE8');
        $this->addSql('ALTER TABLE commande_article RENAME INDEX id_article TO IDX_F4817CC6DCA7A716');
        $this->addSql('ALTER TABLE hotel CHANGE nom_hotel nom_hotel VARCHAR(15) NOT NULL, CHANGE adress_hotel adress_hotel VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY fk_user');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY fk_parking');
        $this->addSql('DROP INDEX fk_user ON place');
        $this->addSql('ALTER TABLE place CHANGE id_parking id_parking INT DEFAULT NULL, CHANGE type_place type_place VARCHAR(30) NOT NULL, CHANGE id_user id_client INT DEFAULT NULL');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD6CAAFB0A FOREIGN KEY (id_parking) REFERENCES parking (id_parking)');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CDE173B1B8 FOREIGN KEY (id_client) REFERENCES client (idPersonne)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_741D53CDE173B1B8 ON place (id_client)');
        $this->addSql('ALTER TABLE place RENAME INDEX fk_parking TO IDX_741D53CD6CAAFB0A');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY reservation_ibfk_2');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY reservation_ibfk_1');
        $this->addSql('ALTER TABLE reservation CHANGE id_hotel id_hotel INT DEFAULT NULL, CHANGE id_personne id_personne INT DEFAULT NULL, CHANGE date_reservation date_reservation DATETIME NOT NULL, CHANGE type_chambre type_chambre VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849555F15257A FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955EDD61FE9 FOREIGN KEY (id_hotel) REFERENCES hotel (id_hotel)');
        $this->addSql('ALTER TABLE reservation RENAME INDEX id_personne TO IDX_42C849555F15257A');
        $this->addSql('ALTER TABLE reservation RENAME INDEX id_hotel TO IDX_42C84955EDD61FE9');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rendez-vous (ref_rendez_vous INT AUTO_INCREMENT NOT NULL, id_medecin INT NOT NULL, id_personne INT NOT NULL, date_rendez_vous DATETIME NOT NULL, INDEX id_medecin (id_medecin), INDEX id_personne (id_personne), PRIMARY KEY(ref_rendez_vous)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE rendez-vous ADD CONSTRAINT rendez-vous_ibfk_1 FOREIGN KEY (id_medecin) REFERENCES medecin (id_medecin) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez-vous ADD CONSTRAINT rendez-vous_ibfk_2 FOREIGN KEY (id_personne) REFERENCES client (id_personne) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billet RENAME INDEX idx_1f034af65f15257a TO indexIdPersonne');
        $this->addSql('ALTER TABLE billet RENAME INDEX idx_1f034af69f39f8b1 TO id_station');
        $this->addSql('ALTER TABLE client DROP nom_personne, DROP prenom_personne, DROP numero_telephone, DROP mail_personne, DROP mdp_personne, DROP image_personne, CHANGE id_personne id_personne INT NOT NULL, CHANGE genre genre VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT fk_client FOREIGN KEY (id_personne) REFERENCES personne (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX indexIdPersonne ON client (id_personne)');
        $this->addSql('CREATE INDEX fk_client ON client (id_personne)');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D5F15257A');
        $this->addSql('DROP INDEX IDX_6EEAA67D5F15257A ON commande');
        $this->addSql('ALTER TABLE commande DROP id_personne, CHANGE prix_totale prix_totale NUMERIC(10, 2) NOT NULL, CHANGE delais_commande delais_commande DATE NOT NULL');
        $this->addSql('DROP INDEX `primary` ON commande_article');
        $this->addSql('ALTER TABLE commande_article CHANGE id_commande id_commande INT DEFAULT NULL, CHANGE id_article id_article INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_article RENAME INDEX idx_f4817cc6dca7a716 TO id_article');
        $this->addSql('ALTER TABLE commande_article RENAME INDEX idx_f4817cc63e314ae8 TO id_commande');
        $this->addSql('ALTER TABLE hotel CHANGE nom_hotel nom_hotel VARCHAR(30) NOT NULL, CHANGE adress_hotel adress_hotel VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD6CAAFB0A');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CDE173B1B8');
        $this->addSql('DROP INDEX UNIQ_741D53CDE173B1B8 ON place');
        $this->addSql('ALTER TABLE place CHANGE id_parking id_parking INT NOT NULL, CHANGE type_place type_place VARCHAR(255) NOT NULL, CHANGE id_client id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT fk_user FOREIGN KEY (id_user) REFERENCES client (id_personne) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT fk_parking FOREIGN KEY (id_parking) REFERENCES parking (id_parking) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX fk_user ON place (id_user)');
        $this->addSql('ALTER TABLE place RENAME INDEX idx_741d53cd6caafb0a TO fk_parking');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849555F15257A');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955EDD61FE9');
        $this->addSql('ALTER TABLE reservation CHANGE id_personne id_personne INT NOT NULL, CHANGE id_hotel id_hotel INT NOT NULL, CHANGE date_reservation date_reservation DATE NOT NULL, CHANGE type_chambre type_chambre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT reservation_ibfk_2 FOREIGN KEY (id_personne) REFERENCES client (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT reservation_ibfk_1 FOREIGN KEY (id_hotel) REFERENCES hotel (id_hotel) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation RENAME INDEX idx_42c84955edd61fe9 TO id_hotel');
        $this->addSql('ALTER TABLE reservation RENAME INDEX idx_42c849555f15257a TO id_personne');
    }
}
