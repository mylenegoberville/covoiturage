<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220728194541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810FDE12AB56');
        $this->addSql('DROP INDEX IDX_E9E2810FDE12AB56 ON voiture');
        $this->addSql('ALTER TABLE voiture CHANGE created_by created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810FB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E9E2810FB03A8386 ON voiture (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810FB03A8386');
        $this->addSql('DROP INDEX IDX_E9E2810FB03A8386 ON voiture');
        $this->addSql('ALTER TABLE voiture CHANGE created_by_id created_by INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810FDE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E9E2810FDE12AB56 ON voiture (created_by)');
    }
}
