<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428095043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_users_group (user_id INT NOT NULL, users_group_id INT NOT NULL, INDEX IDX_23AC2919A76ED395 (user_id), INDEX IDX_23AC29198515F29D (users_group_id), PRIMARY KEY(user_id, users_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_group_user (users_group_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_73A222AD8515F29D (users_group_id), INDEX IDX_73A222ADA76ED395 (user_id), PRIMARY KEY(users_group_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_users_group ADD CONSTRAINT FK_23AC2919A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_users_group ADD CONSTRAINT FK_23AC29198515F29D FOREIGN KEY (users_group_id) REFERENCES users_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_group_user ADD CONSTRAINT FK_73A222AD8515F29D FOREIGN KEY (users_group_id) REFERENCES users_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_group_user ADD CONSTRAINT FK_73A222ADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_users_group DROP FOREIGN KEY FK_23AC2919A76ED395');
        $this->addSql('ALTER TABLE user_users_group DROP FOREIGN KEY FK_23AC29198515F29D');
        $this->addSql('ALTER TABLE users_group_user DROP FOREIGN KEY FK_73A222AD8515F29D');
        $this->addSql('ALTER TABLE users_group_user DROP FOREIGN KEY FK_73A222ADA76ED395');
        $this->addSql('DROP TABLE user_users_group');
        $this->addSql('DROP TABLE users_group');
        $this->addSql('DROP TABLE users_group_user');
    }
}
