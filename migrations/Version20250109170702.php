<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250109170702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bon_de_commande (id INT AUTO_INCREMENT NOT NULL, date DATE DEFAULT NULL, status VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_bon_de_commande (id INT AUTO_INCREMENT NOT NULL, medicament_id INT NOT NULL, bon_de_commande_id INT NOT NULL, user_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_27D963F7AB0D61F7 (medicament_id), INDEX IDX_27D963F7D29E677C (bon_de_commande_id), INDEX IDX_27D963F7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_medicament (id INT AUTO_INCREMENT NOT NULL, medicament_id INT NOT NULL, quantite INT NOT NULL, num_ligne INT DEFAULT NULL, INDEX IDX_79309C27AB0D61F7 (medicament_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, email VARCHAR(20) NOT NULL, num_tel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicament (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, prix DOUBLE PRECISION NOT NULL, photo VARCHAR(255) DEFAULT NULL, qte_stock INT NOT NULL, sur_ordonnance TINYINT(1) NOT NULL, type_med VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordonnance (id INT AUTO_INCREMENT NOT NULL, id_client_id INT DEFAULT NULL, medecin_id INT DEFAULT NULL, ligne_medicament_id INT DEFAULT NULL, date_emission DATE NOT NULL, INDEX IDX_924B326C99DED506 (id_client_id), INDEX IDX_924B326C4F31A84 (medecin_id), INDEX IDX_924B326CA06E6096 (ligne_medicament_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recu (id INT AUTO_INCREMENT NOT NULL, id_client_id INT DEFAULT NULL, totale DOUBLE PRECISION NOT NULL, INDEX IDX_C0D1031799DED506 (id_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recu_ligne_medicament (recu_id INT NOT NULL, ligne_medicament_id INT NOT NULL, INDEX IDX_75D56F25A5D1C184 (recu_id), INDEX IDX_75D56F25A06E6096 (ligne_medicament_id), PRIMARY KEY(recu_id, ligne_medicament_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, role VARCHAR(20) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, num_tel VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ligne_bon_de_commande ADD CONSTRAINT FK_27D963F7AB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id)');
        $this->addSql('ALTER TABLE ligne_bon_de_commande ADD CONSTRAINT FK_27D963F7D29E677C FOREIGN KEY (bon_de_commande_id) REFERENCES bon_de_commande (id)');
        $this->addSql('ALTER TABLE ligne_bon_de_commande ADD CONSTRAINT FK_27D963F7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ligne_medicament ADD CONSTRAINT FK_79309C27AB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C99DED506 FOREIGN KEY (id_client_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C4F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326CA06E6096 FOREIGN KEY (ligne_medicament_id) REFERENCES ligne_medicament (id)');
        $this->addSql('ALTER TABLE recu ADD CONSTRAINT FK_C0D1031799DED506 FOREIGN KEY (id_client_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE recu_ligne_medicament ADD CONSTRAINT FK_75D56F25A5D1C184 FOREIGN KEY (recu_id) REFERENCES recu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recu_ligne_medicament ADD CONSTRAINT FK_75D56F25A06E6096 FOREIGN KEY (ligne_medicament_id) REFERENCES ligne_medicament (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_bon_de_commande DROP FOREIGN KEY FK_27D963F7AB0D61F7');
        $this->addSql('ALTER TABLE ligne_bon_de_commande DROP FOREIGN KEY FK_27D963F7D29E677C');
        $this->addSql('ALTER TABLE ligne_bon_de_commande DROP FOREIGN KEY FK_27D963F7A76ED395');
        $this->addSql('ALTER TABLE ligne_medicament DROP FOREIGN KEY FK_79309C27AB0D61F7');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C99DED506');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C4F31A84');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326CA06E6096');
        $this->addSql('ALTER TABLE recu DROP FOREIGN KEY FK_C0D1031799DED506');
        $this->addSql('ALTER TABLE recu_ligne_medicament DROP FOREIGN KEY FK_75D56F25A5D1C184');
        $this->addSql('ALTER TABLE recu_ligne_medicament DROP FOREIGN KEY FK_75D56F25A06E6096');
        $this->addSql('DROP TABLE bon_de_commande');
        $this->addSql('DROP TABLE ligne_bon_de_commande');
        $this->addSql('DROP TABLE ligne_medicament');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE medicament');
        $this->addSql('DROP TABLE ordonnance');
        $this->addSql('DROP TABLE recu');
        $this->addSql('DROP TABLE recu_ligne_medicament');
        $this->addSql('DROP TABLE `user`');
    }
}
