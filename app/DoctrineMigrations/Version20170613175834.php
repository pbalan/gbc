<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170613175834 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE content (id BIGINT AUTO_INCREMENT NOT NULL, content_type_id INT NOT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, is_deleted VARCHAR(3) DEFAULT \'No\' NOT NULL, is_in_appropriate VARCHAR(3) DEFAULT \'No\' NOT NULL, is_private VARCHAR(3) DEFAULT \'No\' NOT NULL, INDEX IDX_CONTENT_AUTHOR (author_id), INDEX IDX_CONTENT_IS_PRIVATE (is_private), INDEX IDX_CONTENT_TITLE (title), INDEX IDX_CONTENT_CONTENT_TYPE_ID (content_type_id), INDEX IDX_CONTENT_IS_DELETED (is_deleted), INDEX IDX_CONTENT_CREATED_AT (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB COMMENT = \'stores content created by a user\' ');
        $this->addSql('CREATE TABLE content_comment (id BIGINT AUTO_INCREMENT NOT NULL, content_id BIGINT NOT NULL, parent_id BIGINT DEFAULT NULL, user_id INT NOT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL, is_deleted VARCHAR(3) DEFAULT \'No\' NOT NULL, INDEX IDX_CONTENT_COMMENT_CONTENT_ID (content_id), INDEX IDX_CONTENT_COMMENT_PARENT_ID (parent_id), INDEX IDX_CONTENT_COMMENT_USER_ID (user_id), INDEX IDX_CONTENT_COMMENT_CREATED_AT (created_at), INDEX IDX_CONTENT_COMMENT_IS_DELETED (is_deleted), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB COMMENT = \'stores comments related to a content and an existing comment\' ');
        $this->addSql('CREATE TABLE content_like (id INT AUTO_INCREMENT NOT NULL, content_id BIGINT NOT NULL, liked_by INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_CONTENT_LIKE_CONTENT_ID (content_id), INDEX IDX_CONTENT_LIKE_LIKED_BY (liked_by), INDEX IDX_CONTENT_LIKE_CREATED_AT (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB COMMENT = \'stores likes related to a content\' ');
        $this->addSql('CREATE TABLE content_location (id INT AUTO_INCREMENT NOT NULL, content_id BIGINT NOT NULL, geo_lat DOUBLE PRECISION DEFAULT NULL, geo_lng DOUBLE PRECISION DEFAULT NULL, location_name VARCHAR(255) NOT NULL, INDEX IDX_CONTENT_LOCATION_GEO_LAT (geo_lat), INDEX IDX_CONTENT_LOCATION_GEO_LNG (geo_lng), INDEX IDX_CONTENT_LOCATION_LOCATION_NAME (location_name), UNIQUE INDEX UNIQ_CONTENT_LOCATION_CONTENT_ID (content_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB COMMENT = \'stores likes related to a content\' ');
        $this->addSql('CREATE TABLE content_share (id INT AUTO_INCREMENT NOT NULL, content_id BIGINT NOT NULL, share_service_id INT NOT NULL, shared_by INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_CONTENT_SHARE_CONTENT_ID (content_id), INDEX IDX_CONTENT_SHARE_SHARE_SERVICE_ID (share_service_id), INDEX IDX_CONTENT_SHARE_SHARED_BY (shared_by), INDEX IDX_CONTENT_SHARE_CREATED_AT (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB COMMENT = \'stores shares related to a content\' ');
        $this->addSql('CREATE TABLE content_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CONTENT_TYPE_NAME (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB COMMENT = \'stores content types\' ');
        $this->addSql('CREATE TABLE content_upload (id INT AUTO_INCREMENT NOT NULL, content_id BIGINT NOT NULL, created_at DATETIME NOT NULL, file_path VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, is_deleted VARCHAR(3) DEFAULT \'No\' NOT NULL, INDEX IDX_CONTENT_UPLOAD_CONTENT_ID (content_id), INDEX IDX_CONTENT_UPLOAD_IS_DELETED (is_deleted), INDEX IDX_CONTENT_UPLOAD_CREATED_AT (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB COMMENT = \'stores uploads related to a content\' ');
        $this->addSql('CREATE TABLE reported_content (id INT AUTO_INCREMENT NOT NULL, content_id BIGINT NOT NULL, reporter_id INT NOT NULL, report_type_id INT NOT NULL, created_at DATETIME NOT NULL, comments LONGTEXT NOT NULL, INDEX IDX_REPORTED_CONTENT_CONTENT_ID (content_id), INDEX IDX_REPORTED_CONTENT_REPORTER_ID (reporter_id), INDEX IDX_REPORTED_CONTENT_REPORT_TYPE_ID (report_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB COMMENT = \'stores inappropriate content reported by a user\' ');
        $this->addSql('CREATE TABLE report_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_REPORT_CONTENT_NAME (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB COMMENT = \'stores report types\' ');
        $this->addSql('CREATE TABLE share_service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, api_url VARCHAR(255) DEFAULT NULL, client_id VARCHAR(255) DEFAULT NULL, client_secret VARCHAR(255) DEFAULT NULL, client_option VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_SHARE_SERVICE_NAME (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB COMMENT = \'stores unique share services\' ');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A91A445520 FOREIGN KEY (content_type_id) REFERENCES content_types (id)');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A9F675F31B FOREIGN KEY (author_id) REFERENCES gbc_users (id)');
        $this->addSql('ALTER TABLE content_comment ADD CONSTRAINT FK_4B7C8BDF84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE content_comment ADD CONSTRAINT FK_4B7C8BDF727ACA70 FOREIGN KEY (parent_id) REFERENCES content_comment (id)');
        $this->addSql('ALTER TABLE content_comment ADD CONSTRAINT FK_4B7C8BDFA76ED395 FOREIGN KEY (user_id) REFERENCES gbc_users (id)');
        $this->addSql('ALTER TABLE content_like ADD CONSTRAINT FK_6101AD7684A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE content_like ADD CONSTRAINT FK_6101AD76621FAD6B FOREIGN KEY (liked_by) REFERENCES gbc_users (id)');
        $this->addSql('ALTER TABLE content_location ADD CONSTRAINT FK_C29632484A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE content_share ADD CONSTRAINT FK_4C5C98884A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE content_share ADD CONSTRAINT FK_4C5C9889B99120 FOREIGN KEY (share_service_id) REFERENCES share_service (id)');
        $this->addSql('ALTER TABLE content_share ADD CONSTRAINT FK_4C5C988BB668A72 FOREIGN KEY (shared_by) REFERENCES gbc_users (id)');
        $this->addSql('ALTER TABLE content_upload ADD CONSTRAINT FK_7F8B96B384A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE reported_content ADD CONSTRAINT FK_594CB55284A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE reported_content ADD CONSTRAINT FK_594CB552E1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES gbc_users (id)');
        $this->addSql('ALTER TABLE reported_content ADD CONSTRAINT FK_594CB552A5D5F193 FOREIGN KEY (report_type_id) REFERENCES report_types (id)');
        $this->addSql('ALTER TABLE comment_like ADD CONSTRAINT FK_8A55E25FF8697D13 FOREIGN KEY (comment_id) REFERENCES content_comment (id)');
        $this->addSql('ALTER TABLE comment_like ADD CONSTRAINT FK_8A55E25F621FAD6B FOREIGN KEY (liked_by) REFERENCES gbc_users (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE content_comment DROP FOREIGN KEY FK_4B7C8BDF84A0A3ED');
        $this->addSql('ALTER TABLE content_like DROP FOREIGN KEY FK_6101AD7684A0A3ED');
        $this->addSql('ALTER TABLE content_location DROP FOREIGN KEY FK_C29632484A0A3ED');
        $this->addSql('ALTER TABLE content_share DROP FOREIGN KEY FK_4C5C98884A0A3ED');
        $this->addSql('ALTER TABLE content_upload DROP FOREIGN KEY FK_7F8B96B384A0A3ED');
        $this->addSql('ALTER TABLE reported_content DROP FOREIGN KEY FK_594CB55284A0A3ED');
        $this->addSql('ALTER TABLE comment_like DROP FOREIGN KEY FK_8A55E25FF8697D13');
        $this->addSql('ALTER TABLE content_comment DROP FOREIGN KEY FK_4B7C8BDF727ACA70');
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A91A445520');
        $this->addSql('ALTER TABLE reported_content DROP FOREIGN KEY FK_594CB552A5D5F193');
        $this->addSql('ALTER TABLE content_share DROP FOREIGN KEY FK_4C5C9889B99120');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE content_comment');
        $this->addSql('DROP TABLE content_like');
        $this->addSql('DROP TABLE content_location');
        $this->addSql('DROP TABLE content_share');
        $this->addSql('DROP TABLE content_types');
        $this->addSql('DROP TABLE content_upload');
        $this->addSql('DROP TABLE reported_content');
        $this->addSql('DROP TABLE report_types');
        $this->addSql('DROP TABLE share_service');
        $this->addSql('ALTER TABLE comment_like DROP FOREIGN KEY FK_8A55E25F621FAD6B');
    }
}
