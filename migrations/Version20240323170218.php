<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240323170218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY fk_admin');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY fk_client');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY reservation_5');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY user_5');
        $this->addSql('ALTER TABLE reservation CHANGE id_hotel id_hotel INT DEFAULT NULL, CHANGE id_personne id_personne INT DEFAULT NULL, CHANGE date_reservation date_reservation DATETIME NOT NULL, CHANGE type_chambre type_chambre VARCHAR(20) NOT NULL');
        $this->addSql('DROP INDEX user_5 ON reservation');
        $this->addSql('CREATE INDEX IDX_42C849555F15257A ON reservation (id_personne)');
        $this->addSql('DROP INDEX id_hotel ON reservation');
        $this->addSql('CREATE INDEX IDX_42C84955EDD61FE9 ON reservation (id_hotel)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT reservation_5 FOREIGN KEY (id_hotel) REFERENCES hotel (id_hotel)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT user_5 FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT fk_admin FOREIGN KEY (id_personne) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT fk_client FOREIGN KEY (id_personne) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849555F15257A');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955EDD61FE9');
        $this->addSql('ALTER TABLE reservation CHANGE id_personne id_personne INT NOT NULL, CHANGE id_hotel id_hotel INT NOT NULL, CHANGE date_reservation date_reservation DATE NOT NULL, CHANGE type_chambre type_chambre VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX idx_42c84955edd61fe9 ON reservation');
        $this->addSql('CREATE INDEX id_hotel ON reservation (id_hotel)');
        $this->addSql('DROP INDEX idx_42c849555f15257a ON reservation');
        $this->addSql('CREATE INDEX user_5 ON reservation (id_personne)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849555F15257A FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955EDD61FE9 FOREIGN KEY (id_hotel) REFERENCES hotel (id_hotel)');
    }
}
