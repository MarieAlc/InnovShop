<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521114851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE commande ADD numero VARCHAR(255) DEFAULT NULL, ADD rue VARCHAR(255) DEFAULT NULL, ADD code_postal VARCHAR(10) DEFAULT NULL, ADD ville VARCHAR(100) DEFAULT NULL, DROP adresse_livraison
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD numero VARCHAR(255) DEFAULT NULL, ADD rue VARCHAR(255) DEFAULT NULL, ADD code_postal VARCHAR(10) DEFAULT NULL, ADD ville VARCHAR(100) DEFAULT NULL, DROP adresse
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE commande ADD adresse_livraison LONGTEXT NOT NULL, DROP numero, DROP rue, DROP code_postal, DROP ville
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD adresse LONGTEXT DEFAULT NULL, DROP numero, DROP rue, DROP code_postal, DROP ville
        SQL);
    }
}
