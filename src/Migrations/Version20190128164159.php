<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190128164159 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact_data ADD service_id INT NOT NULL');
        $this->addSql('ALTER TABLE contact_data ADD CONSTRAINT FK_850C719CED5CA9E6 FOREIGN KEY (service_id) REFERENCES services_data (id)');
        $this->addSql('CREATE INDEX IDX_850C719CED5CA9E6 ON contact_data (service_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact_data DROP FOREIGN KEY FK_850C719CED5CA9E6');
        $this->addSql('DROP INDEX IDX_850C719CED5CA9E6 ON contact_data');
        $this->addSql('ALTER TABLE contact_data DROP service_id');
    }
}
