<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200116085620 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7D055A291');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7EC470631');
        $this->addSql('DROP INDEX IDX_364071D7EC470631 ON emprunt');
        $this->addSql('DROP INDEX IDX_364071D7D055A291 ON emprunt');
        $this->addSql('ALTER TABLE emprunt ADD lecteur_id INT DEFAULT NULL, ADD livre_id INT DEFAULT NULL, DROP lecteur_id_id, DROP livre_id_id, CHANGE date_emprunt date_emprunt DATETIME NOT NULL, CHANGE date_retour date_retour DATETIME NOT NULL');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D749DB9E60 FOREIGN KEY (lecteur_id) REFERENCES lecteur (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D737D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('CREATE INDEX IDX_364071D749DB9E60 ON emprunt (lecteur_id)');
        $this->addSql('CREATE INDEX IDX_364071D737D925CB ON emprunt (livre_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D749DB9E60');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D737D925CB');
        $this->addSql('DROP INDEX IDX_364071D749DB9E60 ON emprunt');
        $this->addSql('DROP INDEX IDX_364071D737D925CB ON emprunt');
        $this->addSql('ALTER TABLE emprunt ADD lecteur_id_id INT DEFAULT NULL, ADD livre_id_id INT DEFAULT NULL, DROP lecteur_id, DROP livre_id, CHANGE date_emprunt date_emprunt DATE NOT NULL, CHANGE date_retour date_retour DATE NOT NULL');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7D055A291 FOREIGN KEY (lecteur_id_id) REFERENCES lecteur (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7EC470631 FOREIGN KEY (livre_id_id) REFERENCES livre (id)');
        $this->addSql('CREATE INDEX IDX_364071D7EC470631 ON emprunt (livre_id_id)');
        $this->addSql('CREATE INDEX IDX_364071D7D055A291 ON emprunt (lecteur_id_id)');
    }
}
