<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220305114044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense (id INT AUTO_INCREMENT NOT NULL, distribution_id INT DEFAULT NULL, account_id INT NOT NULL, name VARCHAR(100) NOT NULL, amount INT NOT NULL, date DATE NOT NULL, UNIQUE INDEX UNIQ_2D3A8DA66EB6DDB5 (distribution_id), INDEX IDX_2D3A8DA69B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE income (id INT AUTO_INCREMENT NOT NULL, distribution_id INT DEFAULT NULL, account_id INT NOT NULL, name VARCHAR(100) NOT NULL, amount INT NOT NULL, date DATE NOT NULL, UNIQUE INDEX UNIQ_3FA862D06EB6DDB5 (distribution_id), INDEX IDX_3FA862D09B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_distribution (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL COMMENT \'(DC2Type:App\\\\Enum\\\\Bank\\\\DistributionType)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_distribution_account (payment_distribution_id INT NOT NULL, account_id INT NOT NULL, INDEX IDX_96CEDF2F693E3116 (payment_distribution_id), INDEX IDX_96CEDF2F9B6B5FBA (account_id), PRIMARY KEY(payment_distribution_id, account_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6499B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA66EB6DDB5 FOREIGN KEY (distribution_id) REFERENCES payment_distribution (id)');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA69B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE income ADD CONSTRAINT FK_3FA862D06EB6DDB5 FOREIGN KEY (distribution_id) REFERENCES payment_distribution (id)');
        $this->addSql('ALTER TABLE income ADD CONSTRAINT FK_3FA862D09B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE payment_distribution_account ADD CONSTRAINT FK_96CEDF2F693E3116 FOREIGN KEY (payment_distribution_id) REFERENCES payment_distribution (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE payment_distribution_account ADD CONSTRAINT FK_96CEDF2F9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6499B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA69B6B5FBA');
        $this->addSql('ALTER TABLE income DROP FOREIGN KEY FK_3FA862D09B6B5FBA');
        $this->addSql('ALTER TABLE payment_distribution_account DROP FOREIGN KEY FK_96CEDF2F9B6B5FBA');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6499B6B5FBA');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA66EB6DDB5');
        $this->addSql('ALTER TABLE income DROP FOREIGN KEY FK_3FA862D06EB6DDB5');
        $this->addSql('ALTER TABLE payment_distribution_account DROP FOREIGN KEY FK_96CEDF2F693E3116');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE expense');
        $this->addSql('DROP TABLE income');
        $this->addSql('DROP TABLE payment_distribution');
        $this->addSql('DROP TABLE payment_distribution_account');
        $this->addSql('DROP TABLE `user`');
    }
}
