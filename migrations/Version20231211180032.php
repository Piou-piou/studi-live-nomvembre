<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231211180032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logger ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE logger ADD CONSTRAINT FK_987E13F3B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE logger ADD CONSTRAINT FK_987E13F3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_987E13F3B03A8386 ON logger (created_by_id)');
        $this->addSql('CREATE INDEX IDX_987E13F3896DBBDE ON logger (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logger DROP FOREIGN KEY FK_987E13F3B03A8386');
        $this->addSql('ALTER TABLE logger DROP FOREIGN KEY FK_987E13F3896DBBDE');
        $this->addSql('DROP INDEX IDX_987E13F3B03A8386 ON logger');
        $this->addSql('DROP INDEX IDX_987E13F3896DBBDE ON logger');
        $this->addSql('ALTER TABLE logger DROP created_by_id, DROP updated_by_id');
    }
}
