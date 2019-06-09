<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190609140924 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE rankings');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE rankings (id INT AUTO_INCREMENT NOT NULL, voter_id INT UNSIGNED NOT NULL, destination_id INT NOT NULL, grade_id INT DEFAULT NULL, INDEX IDX_9D5DA5E6816C6140 (destination_id), INDEX IDX_9D5DA5E6EBB4B8AD (voter_id), INDEX IDX_9D5DA5E6FE19A1A8 (grade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE rankings ADD CONSTRAINT FK_9D5DA5E6816C6140 FOREIGN KEY (destination_id) REFERENCES destinations (id)');
        $this->addSql('ALTER TABLE rankings ADD CONSTRAINT FK_9D5DA5E6EBB4B8AD FOREIGN KEY (voter_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE rankings ADD CONSTRAINT FK_9D5DA5E6FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grades (id)');
    }
}
