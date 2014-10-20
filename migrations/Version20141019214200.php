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
CREATE SCHEMA IF NOT EXISTS `bmonlinetemplate` DEFAULT CHARACTER SET latin1 ;
USE `bmonlinetemplate` ;

-- -----------------------------------------------------
-- Table `bmonlinetemplate`.`oauth_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bmonlinetemplate`.`oauth_users` (
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(2000) NULL DEFAULT NULL,
  `first_name` VARCHAR(255) NULL DEFAULT NULL,
  `last_name` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`username`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bmonlinetemplate`.`oauth_clients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bmonlinetemplate`.`oauth_clients` (
  `client_id` VARCHAR(80) NOT NULL,
  `client_secret` VARCHAR(80) NOT NULL,
  `redirect_uri` VARCHAR(2000) NOT NULL,
  `grant_types` VARCHAR(80) NULL DEFAULT NULL,
  `scope` VARCHAR(2000) NULL DEFAULT NULL,
  `user_id` VARCHAR(255) NULL DEFAULT NULL,
  `oauth_users_username` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`client_id`),
  INDEX `fk_oauth_clients_oauth_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_oauth_clients_oauth_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `bmonlinetemplate`.`oauth_users` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bmonlinetemplate`.`oauth_access_tokens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bmonlinetemplate`.`oauth_access_tokens` (
  `access_token` VARCHAR(40) NOT NULL,
  `client_id` VARCHAR(80) NOT NULL,
  `user_id` VARCHAR(255) NULL DEFAULT NULL,
  `expires` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` VARCHAR(2000) NULL DEFAULT NULL,
  PRIMARY KEY (`access_token`),
  INDEX `fk_oauth_access_tokens_oauth_clients1_idx` (`client_id` ASC),
  INDEX `fk_oauth_access_tokens_oauth_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_oauth_access_tokens_oauth_clients1`
    FOREIGN KEY (`client_id`)
    REFERENCES `bmonlinetemplate`.`oauth_clients` (`client_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_oauth_access_tokens_oauth_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `bmonlinetemplate`.`oauth_users` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bmonlinetemplate`.`oauth_authorization_codes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bmonlinetemplate`.`oauth_authorization_codes` (
  `authorization_code` VARCHAR(40) NOT NULL,
  `client_id` VARCHAR(80) NOT NULL,
  `user_id` VARCHAR(255) NULL DEFAULT NULL,
  `redirect_uri` VARCHAR(2000) NULL DEFAULT NULL,
  `expires` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` VARCHAR(2000) NULL DEFAULT NULL,
  `id_token` VARCHAR(2000) NULL DEFAULT NULL,
  PRIMARY KEY (`authorization_code`),
  INDEX `fk_oauth_authorization_codes_oauth_access_tokens1_idx` (`id_token` ASC),
  INDEX `fk_oauth_authorization_codes_oauth_clients1_idx` (`client_id` ASC),
  INDEX `fk_oauth_authorization_codes_oauth_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_oauth_authorization_codes_oauth_access_tokens1`
    FOREIGN KEY (`id_token`)
    REFERENCES `bmonlinetemplate`.`oauth_access_tokens` (`access_token`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_oauth_authorization_codes_oauth_clients1`
    FOREIGN KEY (`client_id`)
    REFERENCES `bmonlinetemplate`.`oauth_clients` (`client_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_oauth_authorization_codes_oauth_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `bmonlinetemplate`.`oauth_users` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bmonlinetemplate`.`oauth_jwt`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bmonlinetemplate`.`oauth_jwt` (
  `client_id` VARCHAR(80) NOT NULL,
  `subject` VARCHAR(80) NULL DEFAULT NULL,
  `public_key` VARCHAR(2000) NULL DEFAULT NULL,
  PRIMARY KEY (`client_id`),
  CONSTRAINT `fk_oauth_jwt_oauth_clients1`
    FOREIGN KEY (`client_id`)
    REFERENCES `bmonlinetemplate`.`oauth_clients` (`client_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bmonlinetemplate`.`oauth_refresh_tokens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bmonlinetemplate`.`oauth_refresh_tokens` (
  `refresh_token` VARCHAR(40) NOT NULL,
  `client_id` VARCHAR(80) NOT NULL,
  `user_id` VARCHAR(255) NULL DEFAULT NULL,
  `expires` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` VARCHAR(2000) NULL DEFAULT NULL,
  PRIMARY KEY (`refresh_token`),
  INDEX `fk_oauth_refresh_tokens_oauth_clients1_idx` (`client_id` ASC),
  INDEX `fk_oauth_refresh_tokens_oauth_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_oauth_refresh_tokens_oauth_clients1`
    FOREIGN KEY (`client_id`)
    REFERENCES `bmonlinetemplate`.`oauth_clients` (`client_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_oauth_refresh_tokens_oauth_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `bmonlinetemplate`.`oauth_users` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bmonlinetemplate`.`oauth_scopes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bmonlinetemplate`.`oauth_scopes` (
  `type` VARCHAR(255) NOT NULL DEFAULT 'supported',
  `scope` VARCHAR(2000) NULL DEFAULT NULL,
  `client_id` VARCHAR(80) NULL DEFAULT NULL,
  `is_default` SMALLINT(6) NULL DEFAULT NULL,
  INDEX `fk_oauth_scopes_oauth_clients1_idx` (`client_id` ASC),
  CONSTRAINT `fk_oauth_scopes_oauth_clients1`
    FOREIGN KEY (`client_id`)
    REFERENCES `bmonlinetemplate`.`oauth_clients` (`client_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

SQL;

        $this->addSql(
            $sql
        );
    }

    public function down(MetadataInterface $schema)
    {
        $sql = <<<SQL
DROP TABLE oauth_jwt;
DROP TABLE oauth_scopes;
DROP TABLE oauth_authorization_codes;
DROP TABLE oauth_refresh_tokens;
DROP TABLE oauth_access_tokens;
DROP TABLE oauth_clients;
DROP TABLE oauth_users;
SQL;

        $this->addSql($sql);
    }
}