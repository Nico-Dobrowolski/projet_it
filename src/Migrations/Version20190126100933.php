<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190126100933 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE storage_contact DROP FOREIGN KEY FK_3B5ED55A48D62931');
        $this->addSql('DROP INDEX UNIQ_3B5ED55A48D62931 ON storage_contact');
        $this->addSql('ALTER TABLE storage_contact CHANGE id_service_id service_id INT NOT NULL');
        $this->addSql('ALTER TABLE storage_contact ADD CONSTRAINT FK_3B5ED55AED5CA9E6 FOREIGN KEY (service_id) REFERENCES storage_service (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B5ED55AED5CA9E6 ON storage_contact (service_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE storage_contact DROP FOREIGN KEY FK_3B5ED55AED5CA9E6');
        $this->addSql('DROP INDEX UNIQ_3B5ED55AED5CA9E6 ON storage_contact');
        $this->addSql('ALTER TABLE storage_contact CHANGE service_id id_service_id INT NOT NULL');
        $this->addSql('ALTER TABLE storage_contact ADD CONSTRAINT FK_3B5ED55A48D62931 FOREIGN KEY (id_service_id) REFERENCES storage_service (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B5ED55A48D62931 ON storage_contact (id_service_id)');
    }
}
