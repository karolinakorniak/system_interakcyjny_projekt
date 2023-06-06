<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606200455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questions DROP answer_id');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5B6DEA817 FOREIGN KEY (best_answer_id) REFERENCES answers (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8ADC54D5B6DEA817 ON questions (best_answer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5B6DEA817');
        $this->addSql('DROP INDEX UNIQ_8ADC54D5B6DEA817 ON questions');
        $this->addSql('ALTER TABLE questions ADD answer_id INT NOT NULL');
    }
}
