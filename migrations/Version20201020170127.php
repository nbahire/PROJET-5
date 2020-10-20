<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201020170127 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add ralation in each entity';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, posts_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, moderate TINYINT(1) NOT NULL, INDEX IDX_5F9E962A67B3B43D (users_id), INDEX IDX_5F9E962AD5E258C5 (posts_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posts_categories (posts_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_A8C3AA46D5E258C5 (posts_id), INDEX IDX_A8C3AA46A21214B7 (categories_id), PRIMARY KEY(posts_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AD5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE posts_categories ADD CONSTRAINT FK_A8C3AA46D5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts_categories ADD CONSTRAINT FK_A8C3AA46A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE posts_categories');
    }
}
