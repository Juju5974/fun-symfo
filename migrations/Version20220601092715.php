<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601092715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote ADD post_id_id INT DEFAULT NULL, DROP post_id');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564E85F12B8 FOREIGN KEY (post_id_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_5A108564E85F12B8 ON vote (post_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564E85F12B8');
        $this->addSql('DROP INDEX IDX_5A108564E85F12B8 ON vote');
        $this->addSql('ALTER TABLE vote ADD post_id INT NOT NULL, DROP post_id_id');
    }
}
