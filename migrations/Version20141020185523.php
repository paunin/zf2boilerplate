<?php

namespace ZendDbMigrations\Migrations;

use ZendDbMigrations\Library\AbstractMigration;
use Zend\Db\Metadata\MetadataInterface;

class Version20141020185523 extends AbstractMigration
{

    public function up(MetadataInterface $schema)
    {
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(64) NULL,
  `password_md5` VARCHAR(32) NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT NOW(),
  `activated_at` TIMESTAMP NULL,
  `deleted_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC))
ENGINE = InnoDB
COMMENT = 'Users table without useless information'
SQL;

        $this->addSql($sql);
    }

    public function down(MetadataInterface $schema)
    {
        $this->addSql('DROP TABLE user');
    }
}