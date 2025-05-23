<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250523091050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE articles CHANGE type_id type_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168C54C8C93 FOREIGN KEY (type_id) REFERENCES types (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_BFDD3168C54C8C93 ON articles (type_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168C54C8C93
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_BFDD3168C54C8C93 ON articles
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE articles CHANGE type_id type_id INT NOT NULL
        SQL);
    }
}
