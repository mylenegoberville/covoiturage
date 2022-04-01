<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220401071525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transporter (id INT AUTO_INCREMENT NOT NULL, etat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transporter_trajet (transporter_id INT NOT NULL, trajet_id INT NOT NULL, INDEX IDX_B56287F34F335C8B (transporter_id), INDEX IDX_B56287F3D12A823 (trajet_id), PRIMARY KEY(transporter_id, trajet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transporter_user (transporter_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5E54D3B34F335C8B (transporter_id), INDEX IDX_5E54D3B3A76ED395 (user_id), PRIMARY KEY(transporter_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transporter_trajet ADD CONSTRAINT FK_B56287F34F335C8B FOREIGN KEY (transporter_id) REFERENCES transporter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transporter_trajet ADD CONSTRAINT FK_B56287F3D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transporter_user ADD CONSTRAINT FK_5E54D3B34F335C8B FOREIGN KEY (transporter_id) REFERENCES transporter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transporter_user ADD CONSTRAINT FK_5E54D3B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voiture ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E9E2810FA76ED395 ON voiture (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transporter_trajet DROP FOREIGN KEY FK_B56287F34F335C8B');
        $this->addSql('ALTER TABLE transporter_user DROP FOREIGN KEY FK_5E54D3B34F335C8B');
        $this->addSql('DROP TABLE transporter');
        $this->addSql('DROP TABLE transporter_trajet');
        $this->addSql('DROP TABLE transporter_user');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810FA76ED395');
        $this->addSql('DROP INDEX IDX_E9E2810FA76ED395 ON voiture');
        $this->addSql('ALTER TABLE voiture DROP user_id');
    }
}
