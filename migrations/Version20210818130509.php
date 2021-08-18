<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210818130509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_post_blog_category (blog_post_id INT NOT NULL, blog_category_id INT NOT NULL, INDEX IDX_C9F85ADCA77FBEAF (blog_post_id), INDEX IDX_C9F85ADCCB76011C (blog_category_id), PRIMARY KEY(blog_post_id, blog_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_post_blog_category ADD CONSTRAINT FK_C9F85ADCA77FBEAF FOREIGN KEY (blog_post_id) REFERENCES blog_post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_post_blog_category ADD CONSTRAINT FK_C9F85ADCCB76011C FOREIGN KEY (blog_category_id) REFERENCES blog_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_comment ADD post_id INT NOT NULL');
        $this->addSql('ALTER TABLE blog_comment ADD CONSTRAINT FK_7882EFEF4B89032C FOREIGN KEY (post_id) REFERENCES blog_post (id)');
        $this->addSql('CREATE INDEX IDX_7882EFEF4B89032C ON blog_comment (post_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE blog_post_blog_category');
        $this->addSql('ALTER TABLE blog_comment DROP FOREIGN KEY FK_7882EFEF4B89032C');
        $this->addSql('DROP INDEX IDX_7882EFEF4B89032C ON blog_comment');
        $this->addSql('ALTER TABLE blog_comment DROP post_id');
    }
}
