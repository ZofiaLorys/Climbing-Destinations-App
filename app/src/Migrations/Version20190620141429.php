<?php
/**
 * Migration file Version20190620141429
 */


declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190620141429 extends AbstractMigration
{
    /**
     * Getter for Description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return '';
    }

    /**
     * Method up
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE rankings (id INT AUTO_INCREMENT NOT NULL, voter_id INT UNSIGNED NOT NULL, destination_id INT NOT NULL, grade_id INT DEFAULT NULL, INDEX IDX_9D5DA5E6EBB4B8AD (voter_id), INDEX IDX_9D5DA5E6816C6140 (destination_id), INDEX IDX_9D5DA5E6FE19A1A8 (grade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE countries (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5D66EBAD2B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grades (id INT AUTO_INCREMENT NOT NULL, ranking_id INT DEFAULT NULL, value INT DEFAULT NULL, INDEX IDX_3AE3611020F64684 (ranking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE destinations (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, author_id INT UNSIGNED NOT NULL, title VARCHAR(15) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_2D3343C3F92F3E70 (country_id), INDEX IDX_2D3343C3F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, email VARCHAR(45) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', full_name VARCHAR(45) NOT NULL, UNIQUE INDEX email_idx (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rankings ADD CONSTRAINT FK_9D5DA5E6EBB4B8AD FOREIGN KEY (voter_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE rankings ADD CONSTRAINT FK_9D5DA5E6816C6140 FOREIGN KEY (destination_id) REFERENCES destinations (id)');
        $this->addSql('ALTER TABLE rankings ADD CONSTRAINT FK_9D5DA5E6FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grades (id)');
        $this->addSql('ALTER TABLE grades ADD CONSTRAINT FK_3AE3611020F64684 FOREIGN KEY (ranking_id) REFERENCES rankings (id)');
        $this->addSql('ALTER TABLE destinations ADD CONSTRAINT FK_2D3343C3F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE destinations ADD CONSTRAINT FK_2D3343C3F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
    }

    /**
     * Method down
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE grades DROP FOREIGN KEY FK_3AE3611020F64684');
        $this->addSql('ALTER TABLE destinations DROP FOREIGN KEY FK_2D3343C3F92F3E70');
        $this->addSql('ALTER TABLE rankings DROP FOREIGN KEY FK_9D5DA5E6FE19A1A8');
        $this->addSql('ALTER TABLE rankings DROP FOREIGN KEY FK_9D5DA5E6816C6140');
        $this->addSql('ALTER TABLE rankings DROP FOREIGN KEY FK_9D5DA5E6EBB4B8AD');
        $this->addSql('ALTER TABLE destinations DROP FOREIGN KEY FK_2D3343C3F675F31B');
        $this->addSql('DROP TABLE rankings');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE grades');
        $this->addSql('DROP TABLE destinations');
        $this->addSql('DROP TABLE users');
    }
}
