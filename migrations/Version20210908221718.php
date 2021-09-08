<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210908221718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE portfolio_project_tags (portfolio_project_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_D72D73C5244BDBEE (portfolio_project_id), INDEX IDX_D72D73C58D7B4FB4 (tags_id), PRIMARY KEY(portfolio_project_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE portfolio_project_tags ADD CONSTRAINT FK_D72D73C5244BDBEE FOREIGN KEY (portfolio_project_id) REFERENCES portfolio_project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE portfolio_project_tags ADD CONSTRAINT FK_D72D73C58D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portfolio_project_tags DROP FOREIGN KEY FK_D72D73C58D7B4FB4');
        $this->addSql('DROP TABLE portfolio_project_tags');
        $this->addSql('DROP TABLE tags');
    }
}
