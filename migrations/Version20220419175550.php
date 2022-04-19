<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419175550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, prop_id INT NOT NULL, UNIQUE INDEX UNIQ_4C62E638DEB3FFBD (prop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_user (contact_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A56C54B6E7A1254A (contact_id), INDEX IDX_A56C54B6A76ED395 (user_id), PRIMARY KEY(contact_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE credit_card_info (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, num_carte VARCHAR(255) NOT NULL, date_expi VARCHAR(7) NOT NULL, cvc INT NOT NULL, nom_prenom VARCHAR(255) NOT NULL, INDEX IDX_E670C5E7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, name_discussion VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, last_message VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, budget INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE DEFAULT NULL, heure_debut TIME NOT NULL, heure_fin TIME DEFAULT NULL, type_activite VARCHAR(255) NOT NULL, nb_participant_max INT NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_activite (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, event_id INT NOT NULL, message LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_B1539104A76ED395 (user_id), INDEX IDX_B153910471F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_prive (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, discussion_id INT NOT NULL, message VARCHAR(255) NOT NULL, date DATETIME NOT NULL, INDEX IDX_2DB3B26A76ED395 (user_id), INDEX IDX_2DB3B261ADED311 (discussion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', name VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, stars INT NOT NULL, cover VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, hobbies LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_discussion (user_id INT NOT NULL, discussion_id INT NOT NULL, INDEX IDX_67DE3FE3A76ED395 (user_id), INDEX IDX_67DE3FE31ADED311 (discussion_id), PRIMARY KEY(user_id, discussion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_event (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, user_id INT NOT NULL, active TINYINT(1) NOT NULL, role VARCHAR(255) NOT NULL, INDEX IDX_D96CF1FF71F7E88B (event_id), INDEX IDX_D96CF1FFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638DEB3FFBD FOREIGN KEY (prop_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contact_user ADD CONSTRAINT FK_A56C54B6E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contact_user ADD CONSTRAINT FK_A56C54B6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE credit_card_info ADD CONSTRAINT FK_E670C5E7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message_activite ADD CONSTRAINT FK_B1539104A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message_activite ADD CONSTRAINT FK_B153910471F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE message_prive ADD CONSTRAINT FK_2DB3B26A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message_prive ADD CONSTRAINT FK_2DB3B261ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id)');
        $this->addSql('ALTER TABLE user_discussion ADD CONSTRAINT FK_67DE3FE3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_discussion ADD CONSTRAINT FK_67DE3FE31ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FF71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_user DROP FOREIGN KEY FK_A56C54B6E7A1254A');
        $this->addSql('ALTER TABLE message_prive DROP FOREIGN KEY FK_2DB3B261ADED311');
        $this->addSql('ALTER TABLE user_discussion DROP FOREIGN KEY FK_67DE3FE31ADED311');
        $this->addSql('ALTER TABLE message_activite DROP FOREIGN KEY FK_B153910471F7E88B');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FF71F7E88B');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638DEB3FFBD');
        $this->addSql('ALTER TABLE contact_user DROP FOREIGN KEY FK_A56C54B6A76ED395');
        $this->addSql('ALTER TABLE credit_card_info DROP FOREIGN KEY FK_E670C5E7A76ED395');
        $this->addSql('ALTER TABLE message_activite DROP FOREIGN KEY FK_B1539104A76ED395');
        $this->addSql('ALTER TABLE message_prive DROP FOREIGN KEY FK_2DB3B26A76ED395');
        $this->addSql('ALTER TABLE user_discussion DROP FOREIGN KEY FK_67DE3FE3A76ED395');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FFA76ED395');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE contact_user');
        $this->addSql('DROP TABLE credit_card_info');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE message_activite');
        $this->addSql('DROP TABLE message_prive');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_discussion');
        $this->addSql('DROP TABLE user_event');
    }
}
