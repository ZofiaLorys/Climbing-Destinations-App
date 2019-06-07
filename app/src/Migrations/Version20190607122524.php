<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190607122524 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rankings ADD grade_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rankings ADD CONSTRAINT FK_9D5DA5E6FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grades (id)');
        $this->addSql('CREATE INDEX IDX_9D5DA5E6FE19A1A8 ON rankings (grade_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rankings DROP FOREIGN KEY FK_9D5DA5E6FE19A1A8');
        $this->addSql('DROP INDEX IDX_9D5DA5E6FE19A1A8 ON rankings');
        $this->addSql('ALTER TABLE rankings DROP grade_id');
    }
}
