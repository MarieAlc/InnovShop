<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521100921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE panier ADD taille_id INT DEFAULT NULL, ADD couleur_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2FF25611A FOREIGN KEY (taille_id) REFERENCES tailles (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2C31BA576 FOREIGN KEY (couleur_id) REFERENCES couleurs (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_24CC0DF2FF25611A ON panier (taille_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_24CC0DF2C31BA576 ON panier (couleur_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2FF25611A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2C31BA576
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_24CC0DF2FF25611A ON panier
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_24CC0DF2C31BA576 ON panier
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panier DROP taille_id, DROP couleur_id
        SQL);
    }
}
