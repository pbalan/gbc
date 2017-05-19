<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170519101611 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ext_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX translations_lookup_idx (locale, object_class, foreign_key), UNIQUE INDEX lookup_unique_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE companies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE designations (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_387A1049232D562B (object_id), UNIQUE INDEX UNIQ_COMPANY_TRANSLATION (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE designation_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_8D54D690232D562B (object_id), UNIQUE INDEX UNIQ_DESIGNATION_TRANSLATION (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_E57EE6CA232D562B (object_id), UNIQUE INDEX UNIQ_UNIVERSITY_TRANSLATION (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE universities (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gbc_users (id INT AUTO_INCREMENT NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', locale VARCHAR(255) DEFAULT \'en\' NOT NULL, intl_code VARCHAR(255) DEFAULT NULL, mobile_number VARCHAR(255) DEFAULT NULL, facebook_id VARCHAR(255) DEFAULT NULL, google_id VARCHAR(255) DEFAULT NULL, linkedin_id VARCHAR(255) DEFAULT NULL, wechat_id VARCHAR(255) DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, username_canonical VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, email_canonical VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_D9E2E1ABC05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_details (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, designation_id INT DEFAULT NULL, company_id INT DEFAULT NULL, university_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, INDEX IDX_2A2B1580A76ED395 (user_id), INDEX IDX_2A2B1580FAC7D83F (designation_id), INDEX IDX_2A2B1580979B1AD6 (company_id), INDEX IDX_2A2B1580309D1878 (university_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_GROUP_TYPE_NAME (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_users (id INT AUTO_INCREMENT NOT NULL, user_group_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_GROUP_USERS_USER_GROUP_ID (user_group_id), INDEX IDX_GROUP_USERS_USER_ID (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_group (id INT AUTO_INCREMENT NOT NULL, group_type_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_USER_GROUP_USER_ID (user_id), INDEX IDX_USER_GROUP_GROUP_TYPE_ID (group_type_id), UNIQUE INDEX UNIQ_USER_GROUP_USER_ID_NAME (name, user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_translations ADD CONSTRAINT FK_387A1049232D562B FOREIGN KEY (object_id) REFERENCES companies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE designation_translations ADD CONSTRAINT FK_8D54D690232D562B FOREIGN KEY (object_id) REFERENCES designations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE university_translations ADD CONSTRAINT FK_E57EE6CA232D562B FOREIGN KEY (object_id) REFERENCES universities (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_details ADD CONSTRAINT FK_2A2B1580A76ED395 FOREIGN KEY (user_id) REFERENCES gbc_users (id)');
        $this->addSql('ALTER TABLE user_details ADD CONSTRAINT FK_2A2B1580FAC7D83F FOREIGN KEY (designation_id) REFERENCES designations (id)');
        $this->addSql('ALTER TABLE user_details ADD CONSTRAINT FK_2A2B1580979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE user_details ADD CONSTRAINT FK_2A2B1580309D1878 FOREIGN KEY (university_id) REFERENCES universities (id)');
        $this->addSql('ALTER TABLE group_users ADD CONSTRAINT FK_44AF8E8E1ED93D47 FOREIGN KEY (user_group_id) REFERENCES group_users (id)');
        $this->addSql('ALTER TABLE group_users ADD CONSTRAINT FK_44AF8E8EA76ED395 FOREIGN KEY (user_id) REFERENCES gbc_users (id)');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT FK_8F02BF9D434CD89F FOREIGN KEY (group_type_id) REFERENCES group_types (id)');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT FK_8F02BF9DA76ED395 FOREIGN KEY (user_id) REFERENCES gbc_users (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company_translations DROP FOREIGN KEY FK_387A1049232D562B');
        $this->addSql('ALTER TABLE user_details DROP FOREIGN KEY FK_2A2B1580979B1AD6');
        $this->addSql('ALTER TABLE designation_translations DROP FOREIGN KEY FK_8D54D690232D562B');
        $this->addSql('ALTER TABLE user_details DROP FOREIGN KEY FK_2A2B1580FAC7D83F');
        $this->addSql('ALTER TABLE university_translations DROP FOREIGN KEY FK_E57EE6CA232D562B');
        $this->addSql('ALTER TABLE user_details DROP FOREIGN KEY FK_2A2B1580309D1878');
        $this->addSql('ALTER TABLE user_details DROP FOREIGN KEY FK_2A2B1580A76ED395');
        $this->addSql('ALTER TABLE group_users DROP FOREIGN KEY FK_44AF8E8EA76ED395');
        $this->addSql('ALTER TABLE user_group DROP FOREIGN KEY FK_8F02BF9DA76ED395');
        $this->addSql('ALTER TABLE user_group DROP FOREIGN KEY FK_8F02BF9D434CD89F');
        $this->addSql('ALTER TABLE group_users DROP FOREIGN KEY FK_44AF8E8E1ED93D47');
        $this->addSql('DROP TABLE ext_translations');
        $this->addSql('DROP TABLE companies');
        $this->addSql('DROP TABLE designations');
        $this->addSql('DROP TABLE company_translations');
        $this->addSql('DROP TABLE designation_translations');
        $this->addSql('DROP TABLE university_translations');
        $this->addSql('DROP TABLE universities');
        $this->addSql('DROP TABLE gbc_users');
        $this->addSql('DROP TABLE user_details');
        $this->addSql('DROP TABLE group_types');
        $this->addSql('DROP TABLE group_users');
        $this->addSql('DROP TABLE user_group');
    }
}
