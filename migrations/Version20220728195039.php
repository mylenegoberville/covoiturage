<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220728195039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CA76ED395');
        $this->addSql('DROP INDEX IDX_2B5BA98CA76ED395 ON trajet');
        $this->addSql('ALTER TABLE trajet CHANGE user_id created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2B5BA98CB03A8386 ON trajet (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CB03A8386');
        $this->addSql('DROP INDEX IDX_2B5BA98CB03A8386 ON trajet');
        $this->addSql('ALTER TABLE trajet CHANGE created_by_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2B5BA98CA76ED395 ON trajet (user_id)');
    }
}
