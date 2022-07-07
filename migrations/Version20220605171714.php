<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220605171714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD subscriber_id INT DEFAULT NULL, DROP user_id');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D7808B1AD FOREIGN KEY (subscriber_id) REFERENCES subscriber (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D7808B1AD ON post (subscriber_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D7808B1AD');
        $this->addSql('DROP INDEX IDX_5A8A6C8D7808B1AD ON post');
        $this->addSql('ALTER TABLE post ADD user_id INT NOT NULL, DROP subscriber_id');
    }
}
