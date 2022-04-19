<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415135106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE discussion CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE message_prive CHANGE id id INT NOT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE discussion_id discussion_id INT DEFAULT NULL, CHANGE date date VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE discussion CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE message_prive CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE user_id user_id INT NOT NULL, CHANGE discussion_id discussion_id INT NOT NULL, CHANGE date date DATETIME NOT NULL');
    }
}
