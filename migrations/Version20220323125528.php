<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220323125528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE charge_group (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, name VARCHAR(100) NOT NULL, amount INT NOT NULL, INDEX IDX_7BE448ED9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE charge_group ADD CONSTRAINT FK_7BE448ED9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE expense ADD charge_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA658BC65D4 FOREIGN KEY (charge_group_id) REFERENCES charge_group (id)');
        $this->addSql('CREATE INDEX IDX_2D3A8DA658BC65D4 ON expense (charge_group_id)');
        $this->addSql('ALTER TABLE income ADD charge_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE income ADD CONSTRAINT FK_3FA862D058BC65D4 FOREIGN KEY (charge_group_id) REFERENCES charge_group (id)');
        $this->addSql('CREATE INDEX IDX_3FA862D058BC65D4 ON income (charge_group_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA658BC65D4');
        $this->addSql('ALTER TABLE income DROP FOREIGN KEY FK_3FA862D058BC65D4');
        $this->addSql('DROP TABLE charge_group');
        $this->addSql('ALTER TABLE account CHANGE name name VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX IDX_2D3A8DA658BC65D4 ON expense');
        $this->addSql('ALTER TABLE expense DROP charge_group_id, CHANGE name name VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX IDX_3FA862D058BC65D4 ON income');
        $this->addSql('ALTER TABLE income DROP charge_group_id, CHANGE name name VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE payment_distribution CHANGE type type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:App\\\\Enum\\\\Bank\\\\DistributionType)\'');
        $this->addSql('ALTER TABLE `user` CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
