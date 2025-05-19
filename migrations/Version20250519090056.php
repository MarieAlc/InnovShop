<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250519090056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE couleurs (id INT AUTO_INCREMENT NOT NULL, valeur VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE couleurs_articles (couleurs_id INT NOT NULL, articles_id INT NOT NULL, INDEX IDX_AED9470F5ED47289 (couleurs_id), INDEX IDX_AED9470F1EBAF6CC (articles_id), PRIMARY KEY(couleurs_id, articles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE tailles (id INT AUTO_INCREMENT NOT NULL, valeur VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE tailles_articles (tailles_id INT NOT NULL, articles_id INT NOT NULL, INDEX IDX_CC5A7CC21AEC613E (tailles_id), INDEX IDX_CC5A7CC21EBAF6CC (articles_id), PRIMARY KEY(tailles_id, articles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE couleurs_articles ADD CONSTRAINT FK_AED9470F5ED47289 FOREIGN KEY (couleurs_id) REFERENCES couleurs (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE couleurs_articles ADD CONSTRAINT FK_AED9470F1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tailles_articles ADD CONSTRAINT FK_CC5A7CC21AEC613E FOREIGN KEY (tailles_id) REFERENCES tailles (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tailles_articles ADD CONSTRAINT FK_CC5A7CC21EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE articles CHANGE detail detail LONGTEXT NOT NULL, CHANGE specification specification LONGTEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande CHANGE adresse_livraison adresse_livraison LONGTEXT NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE couleurs_articles DROP FOREIGN KEY FK_AED9470F5ED47289
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE couleurs_articles DROP FOREIGN KEY FK_AED9470F1EBAF6CC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tailles_articles DROP FOREIGN KEY FK_CC5A7CC21AEC613E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tailles_articles DROP FOREIGN KEY FK_CC5A7CC21EBAF6CC
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE couleurs
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE couleurs_articles
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE tailles
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE tailles_articles
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE articles CHANGE detail detail TEXT NOT NULL, CHANGE specification specification TEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande CHANGE adresse_livraison adresse_livraison TEXT NOT NULL
        SQL);
    }
}
