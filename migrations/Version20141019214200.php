<?php

namespace ZendDbMigrations\Migrations;

use ZendDbMigrations\Library\AbstractMigration;
use Zend\Db\Metadata\MetadataInterface;

class Version20141019214200 extends AbstractMigration
{

    public function up(MetadataInterface $schema)
    {
        $sql = <<<SQL
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema bmonlinetemplate
-- -----------------------------------------------------
-- Main db for bm.online

-- -----------------------------------------------------
-- Table `oauth_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oauth_users` (
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(2000) NULL DEFAULT NULL,
  `first_name` VARCHAR(255) NULL DEFAULT NULL,
  `last_name` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`username`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `oauth_clients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `client_id` VARCHAR(80) NOT NULL,
  `client_secret` VARCHAR(80) NULL,
  `redirect_uri` VARCHAR(2000) NOT NULL,
  `grant_types` VARCHAR(80) NULL DEFAULT NULL,
  `scope` VARCHAR(2000) NULL DEFAULT NULL,
  `user_id` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`client_id`),
  CONSTRAINT `fk_oauth_clients_oauth_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `oauth_users` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_oauth_clients_oauth_users1_idx` ON `oauth_clients` (`user_id` ASC);


-- -----------------------------------------------------
-- Table `oauth_access_tokens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `access_token` VARCHAR(40) NOT NULL,
  `client_id` VARCHAR(80) NOT NULL,
  `user_id` VARCHAR(255) NULL DEFAULT NULL,
  `expires` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` VARCHAR(2000) NULL DEFAULT NULL,
  PRIMARY KEY (`access_token`),
  CONSTRAINT `fk_oauth_access_tokens_oauth_clients1`
    FOREIGN KEY (`client_id`)
    REFERENCES `oauth_clients` (`client_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_oauth_access_tokens_oauth_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `oauth_users` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_oauth_access_tokens_oauth_clients1_idx` ON `oauth_access_tokens` (`client_id` ASC);

CREATE INDEX `fk_oauth_access_tokens_oauth_users1_idx` ON `oauth_access_tokens` (`user_id` ASC);


-- -----------------------------------------------------
-- Table `oauth_authorization_codes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oauth_authorization_codes` (
  `authorization_code` VARCHAR(40) NOT NULL,
  `client_id` VARCHAR(80) NOT NULL,
  `user_id` VARCHAR(255) NULL DEFAULT NULL,
  `redirect_uri` VARCHAR(2000) NULL DEFAULT NULL,
  `expires` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` VARCHAR(2000) NULL DEFAULT NULL,
  `id_token` VARCHAR(40) NULL DEFAULT NULL,
  PRIMARY KEY (`authorization_code`),
  CONSTRAINT `fk_oauth_authorization_codes_oauth_access_tokens1`
    FOREIGN KEY (`id_token`)
    REFERENCES `oauth_access_tokens` (`access_token`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_oauth_authorization_codes_oauth_clients1`
    FOREIGN KEY (`client_id`)
    REFERENCES `oauth_clients` (`client_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_oauth_authorization_codes_oauth_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `oauth_users` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_oauth_authorization_codes_oauth_access_tokens1_idx` ON `oauth_authorization_codes` (`id_token` ASC);

CREATE INDEX `fk_oauth_authorization_codes_oauth_clients1_idx` ON `oauth_authorization_codes` (`client_id` ASC);

CREATE INDEX `fk_oauth_authorization_codes_oauth_users1_idx` ON `oauth_authorization_codes` (`user_id` ASC);


-- -----------------------------------------------------
-- Table `oauth_jwt`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oauth_jwt` (
  `client_id` VARCHAR(80) NOT NULL,
  `subject` VARCHAR(80) NULL DEFAULT NULL,
  `public_key` VARCHAR(2000) NULL DEFAULT NULL,
  PRIMARY KEY (`client_id`),
  CONSTRAINT `fk_oauth_jwt_oauth_clients1`
    FOREIGN KEY (`client_id`)
    REFERENCES `oauth_clients` (`client_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `oauth_refresh_tokens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `refresh_token` VARCHAR(40) NOT NULL,
  `client_id` VARCHAR(80) NOT NULL,
  `user_id` VARCHAR(255) NULL DEFAULT NULL,
  `expires` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` VARCHAR(2000) NULL DEFAULT NULL,
  PRIMARY KEY (`refresh_token`),
  CONSTRAINT `fk_oauth_refresh_tokens_oauth_clients1`
    FOREIGN KEY (`client_id`)
    REFERENCES `oauth_clients` (`client_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_oauth_refresh_tokens_oauth_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `oauth_users` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_oauth_refresh_tokens_oauth_clients1_idx` ON `oauth_refresh_tokens` (`client_id` ASC);

CREATE INDEX `fk_oauth_refresh_tokens_oauth_users1_idx` ON `oauth_refresh_tokens` (`user_id` ASC);


-- -----------------------------------------------------
-- Table `oauth_scopes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oauth_scopes` (
  `type` VARCHAR(255) NOT NULL DEFAULT 'supported',
  `scope` VARCHAR(2000) NULL DEFAULT NULL,
  `client_id` VARCHAR(80) NULL DEFAULT NULL,
  `is_default` SMALLINT(6) NULL DEFAULT NULL,
  CONSTRAINT `fk_oauth_scopes_oauth_clients1`
    FOREIGN KEY (`client_id`)
    REFERENCES `oauth_clients` (`client_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_oauth_scopes_oauth_clients1_idx` ON `oauth_scopes` (`client_id` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `oauth_users`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `oauth_users` (`username`, `password`, `first_name`, `last_name`) VALUES ('testuser', '$2y$14\$f3qml4G2hG6sxM26VMq.geDYbsS089IBtVJ7DlD05BoViS9PFykE2', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `oauth_clients`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `oauth_clients` (`client_id`, `client_secret`, `redirect_uri`, `grant_types`, `scope`, `user_id`) VALUES ('testclient', '$2y$14\$f3qml4G2hG6sxM26VMq.geDYbsS089IBtVJ7DlD05BoViS9PFykE2', '/oauth/receivecode', NULL, NULL, NULL);
INSERT INTO `oauth_clients` (`client_id`, `client_secret`, `redirect_uri`, `grant_types`, `scope`, `user_id`) VALUES ('testclient2', NULL, '/oauth/receivecode', NULL, NULL, NULL);

COMMIT;


SQL;

        $this->addSql(
            $sql
        );
    }

    public function down(MetadataInterface $schema)
    {
        $sql = <<<SQL
DROP TABLE IF EXISTS oauth_jwt;
DROP TABLE IF EXISTS  oauth_scopes;
DROP TABLE IF EXISTS  oauth_authorization_codes;
DROP TABLE IF EXISTS  oauth_refresh_tokens;
DROP TABLE IF EXISTS  oauth_access_tokens;
DROP TABLE IF EXISTS  oauth_clients;
DROP TABLE IF EXISTS  oauth_users;
SQL;

        $this->addSql($sql);
    }
}