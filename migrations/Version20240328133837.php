<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328133837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
     
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY user_2');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY rendezvous_ibfk_1');
        $this->addSql('ALTER TABLE rendez_vous CHANGE ref_rendez_vous ref_rendez_vous VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AC547FAB6 FOREIGN KEY (id_medecin) REFERENCES medecin (id_medecin)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A5F15257A FOREIGN KEY (id_personne) REFERENCES client (id_personne)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrateur DROP nom_personne, DROP prenom_personne, DROP numero_telephone, DROP mail_personne, DROP mdp_personne, DROP image_personne');
        $this->addSql('ALTER TABLE client DROP nom_personne, DROP prenom_personne, DROP numero_telephone, DROP mail_personne, DROP mdp_personne, DROP image_personne');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AC547FAB6');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A5F15257A');
        $this->addSql('ALTER TABLE rendez_vous CHANGE ref_rendez_vous ref_rendez_vous INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT user_2 FOREIGN KEY (id_personne) REFERENCES client (id_personne) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT rendezvous_ibfk_1 FOREIGN KEY (id_medecin) REFERENCES medecin (id_medecin) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
