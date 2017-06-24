<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170622033438 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE followers (id BIGINT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, follower_id INT NOT NULL, created_at DATETIME NOT NULL, is_unfollowed VARCHAR(3) DEFAULT \'No\' NOT NULL, un_followed_at DATETIME DEFAULT NULL, INDEX IDX_8408FDA7AC24F853 (follower_id), INDEX IDX_FOLLOWER_USER_ID (user_id), INDEX IDX_FOLLOWER_IS_UNFOLLOWED (is_unfollowed), INDEX IDX_FOLLOWER_CREATED_AT (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB COMMENT = \'stores follower of user.\' ');
        $this->addSql('CREATE TABLE friends (id BIGINT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, friend_id INT NOT NULL, created_at DATETIME NOT NULL, is_pending VARCHAR(3) DEFAULT \'Yes\' NOT NULL COMMENT \'A user must accept friend request until then its pending.\', is_deleted VARCHAR(3) DEFAULT \'No\' NOT NULL COMMENT \'Record soft/hard break-ups in relationship.\', deleted_at DATETIME DEFAULT NULL COMMENT \'Record when the friendship got affected.\', INDEX IDX_21EE70696A5458E8 (friend_id), INDEX IDX_FRIEND_USER_ID (user_id), INDEX IDX_FRIEND_IS_DELETED (is_deleted), INDEX IDX_FRIEND_CREATED_AT (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB COMMENT = \'stores friends of user.\' ');
        $this->addSql('ALTER TABLE followers ADD CONSTRAINT FK_8408FDA7A76ED395 FOREIGN KEY (user_id) REFERENCES gbc_users (id)');
        $this->addSql('ALTER TABLE followers ADD CONSTRAINT FK_8408FDA7AC24F853 FOREIGN KEY (follower_id) REFERENCES gbc_users (id)');
        $this->addSql('ALTER TABLE friends ADD CONSTRAINT FK_21EE7069A76ED395 FOREIGN KEY (user_id) REFERENCES gbc_users (id)');
        $this->addSql('ALTER TABLE friends ADD CONSTRAINT FK_21EE70696A5458E8 FOREIGN KEY (friend_id) REFERENCES gbc_users (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE followers');
        $this->addSql('DROP TABLE friends');
    }
}
