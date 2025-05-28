<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250527082536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE articles_user (articles_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D76F110E1EBAF6CC (articles_id), INDEX IDX_D76F110EA76ED395 (user_id), PRIMARY KEY(articles_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE articles_user ADD CONSTRAINT FK_D76F110E1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE articles_user ADD CONSTRAINT FK_D76F110EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE articles_user DROP FOREIGN KEY FK_D76F110E1EBAF6CC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE articles_user DROP FOREIGN KEY FK_D76F110EA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE articles_user
        SQL);
    }
}
