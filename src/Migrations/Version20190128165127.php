<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190128165127 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact_data ADD CONSTRAINT FK_850C719CED5CA9E6 FOREIGN KEY (service_id) REFERENCES services_data (id)');
        $this->addSql('CREATE INDEX IDX_850C719CED5CA9E6 ON contact_data (service_id)');
        $this->addSql('ALTER TABLE services_data DROP FOREIGN KEY services_data_ibfk_1');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact_data DROP FOREIGN KEY FK_850C719CED5CA9E6');
        $this->addSql('DROP INDEX IDX_850C719CED5CA9E6 ON contact_data');
        $this->addSql('ALTER TABLE services_data ADD CONSTRAINT services_data_ibfk_1 FOREIGN KEY (id) REFERENCES contact_data (id)');
    }
}
