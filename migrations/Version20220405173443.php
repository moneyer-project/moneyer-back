<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220405173443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE charge (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, distribution_id INT DEFAULT NULL, account_id INT NOT NULL, charge_group_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, amount INT NOT NULL, date DATE NOT NULL, INDEX IDX_556BA4346EB6DDB5 (distribution_id), INDEX IDX_556BA4349B6B5FBA (account_id), INDEX IDX_556BA43458BC65D4 (charge_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE charge_group (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, account_id INT NOT NULL, name VARCHAR(100) NOT NULL, amount INT NOT NULL, INDEX IDX_7BE448ED9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA4346EB6DDB5 FOREIGN KEY (distribution_id) REFERENCES payment_distribution (id)');
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA4349B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA43458BC65D4 FOREIGN KEY (charge_group_id) REFERENCES charge_group (id)');
        $this->addSql('ALTER TABLE charge_group ADD CONSTRAINT FK_7BE448ED9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('DROP TABLE expense');
        $this->addSql('DROP TABLE income');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE charge DROP FOREIGN KEY FK_556BA43458BC65D4');
        $this->addSql('CREATE TABLE expense (id INT AUTO_INCREMENT NOT NULL, distribution_id INT DEFAULT NULL, account_id INT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, amount INT NOT NULL, date DATE NOT NULL, UNIQUE INDEX UNIQ_2D3A8DA66EB6DDB5 (distribution_id), INDEX IDX_2D3A8DA69B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE income (id INT AUTO_INCREMENT NOT NULL, distribution_id INT DEFAULT NULL, account_id INT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, amount INT NOT NULL, date DATE NOT NULL, UNIQUE INDEX UNIQ_3FA862D06EB6DDB5 (distribution_id), INDEX IDX_3FA862D09B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA66EB6DDB5 FOREIGN KEY (distribution_id) REFERENCES payment_distribution (id)');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA69B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE income ADD CONSTRAINT FK_3FA862D06EB6DDB5 FOREIGN KEY (distribution_id) REFERENCES payment_distribution (id)');
        $this->addSql('ALTER TABLE income ADD CONSTRAINT FK_3FA862D09B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('DROP TABLE charge');
        $this->addSql('DROP TABLE charge_group');
        $this->addSql('ALTER TABLE account CHANGE name name VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE payment_distribution CHANGE type type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:App\\\\Enum\\\\Bank\\\\DistributionType)\'');
        $this->addSql('ALTER TABLE `user` CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
