<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200722134324 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE performance_date DROP FOREIGN KEY FK_6265B947B897366B');
        $this->addSql('ALTER TABLE performance_date DROP FOREIGN KEY FK_6265B947B91ADEEE');
        $this->addSql('ALTER TABLE performance_date ADD id INT AUTO_INCREMENT NOT NULL, CHANGE performance_id performance_id INT DEFAULT NULL, CHANGE date_id date_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE performance_date ADD CONSTRAINT FK_6265B947B897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE performance_date ADD CONSTRAINT FK_6265B947B91ADEEE FOREIGN KEY (performance_id) REFERENCES performance (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE performance_date MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE performance_date DROP FOREIGN KEY FK_6265B947B91ADEEE');
        $this->addSql('ALTER TABLE performance_date DROP FOREIGN KEY FK_6265B947B897366B');
        $this->addSql('ALTER TABLE performance_date DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE performance_date DROP id, CHANGE performance_id performance_id INT NOT NULL, CHANGE date_id date_id INT NOT NULL');
        $this->addSql('ALTER TABLE performance_date ADD CONSTRAINT FK_6265B947B91ADEEE FOREIGN KEY (performance_id) REFERENCES performance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE performance_date ADD CONSTRAINT FK_6265B947B897366B FOREIGN KEY (date_id) REFERENCES date (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE performance_date ADD PRIMARY KEY (performance_id, date_id)');
    }
}
