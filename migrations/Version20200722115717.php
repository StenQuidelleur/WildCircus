<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200722115717 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE age_range (id INT AUTO_INCREMENT NOT NULL, spectator VARCHAR(255) NOT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, resume LONGTEXT NOT NULL, INDEX IDX_159968712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banner (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, message LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_perf (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE date (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE performance (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, resume LONGTEXT NOT NULL, price INT NOT NULL, INDEX IDX_82D7968112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE performance_date (performance_id INT NOT NULL, date_id INT NOT NULL, INDEX IDX_6265B947B91ADEEE (performance_id), INDEX IDX_6265B947B897366B (date_id), PRIMARY KEY(performance_id, date_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE performance_artist (performance_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_61B1B8E5B91ADEEE (performance_id), INDEX IDX_61B1B8E5B7970CF8 (artist_id), PRIMARY KEY(performance_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, performance_id INT DEFAULT NULL, age_range_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_97A0ADA3B91ADEEE (performance_id), INDEX IDX_97A0ADA364482BF8 (age_range_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist ADD CONSTRAINT FK_159968712469DE2 FOREIGN KEY (category_id) REFERENCES category_perf (id)');
        $this->addSql('ALTER TABLE performance ADD CONSTRAINT FK_82D7968112469DE2 FOREIGN KEY (category_id) REFERENCES category_perf (id)');
        $this->addSql('ALTER TABLE performance_date ADD CONSTRAINT FK_6265B947B91ADEEE FOREIGN KEY (performance_id) REFERENCES performance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE performance_date ADD CONSTRAINT FK_6265B947B897366B FOREIGN KEY (date_id) REFERENCES date (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE performance_artist ADD CONSTRAINT FK_61B1B8E5B91ADEEE FOREIGN KEY (performance_id) REFERENCES performance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE performance_artist ADD CONSTRAINT FK_61B1B8E5B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3B91ADEEE FOREIGN KEY (performance_id) REFERENCES performance (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA364482BF8 FOREIGN KEY (age_range_id) REFERENCES age_range (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA364482BF8');
        $this->addSql('ALTER TABLE performance_artist DROP FOREIGN KEY FK_61B1B8E5B7970CF8');
        $this->addSql('ALTER TABLE artist DROP FOREIGN KEY FK_159968712469DE2');
        $this->addSql('ALTER TABLE performance DROP FOREIGN KEY FK_82D7968112469DE2');
        $this->addSql('ALTER TABLE performance_date DROP FOREIGN KEY FK_6265B947B897366B');
        $this->addSql('ALTER TABLE performance_date DROP FOREIGN KEY FK_6265B947B91ADEEE');
        $this->addSql('ALTER TABLE performance_artist DROP FOREIGN KEY FK_61B1B8E5B91ADEEE');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3B91ADEEE');
        $this->addSql('DROP TABLE age_range');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE banner');
        $this->addSql('DROP TABLE category_perf');
        $this->addSql('DROP TABLE date');
        $this->addSql('DROP TABLE performance');
        $this->addSql('DROP TABLE performance_date');
        $this->addSql('DROP TABLE performance_artist');
        $this->addSql('DROP TABLE ticket');
    }
}
