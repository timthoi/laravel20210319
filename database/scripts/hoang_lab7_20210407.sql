CREATE TABLE `laravel20210319`.`titles` (
`title_id` INT NOT NULL AUTO_INCREMENT ,
`title_name` VARCHAR(255) NOT NULL ,
`created_by` VARCHAR(255) NOT NULL ,
`created_date` DATETIME NOT NULL ,
`modified_by` VARCHAR(255) NOT NULL ,
`modified_date` DATETIME NOT NULL ,
`is_deleted` TINYINT NOT NULL ,
`data` TEXT NOT NULL ,
PRIMARY KEY (`title_id`)) ENGINE = InnoDB;

ALTER TABLE `titles`
CHANGE `created_date` `created_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
CHANGE `modified_date` `modified_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
CHANGE `is_deleted` `is_deleted` TINYINT(4) NOT NULL DEFAULT '0';


CREATE TABLE `laravel20210319`.`user_titles` (
`user_title_id` INT NOT NULL AUTO_INCREMENT ,
`user_id` INT NOT NULL ,
`title_id` INT NOT NULL ,
`created_by` VARCHAR(255) NOT NULL ,
`created_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`modified_by` VARCHAR(255) NOT NULL ,
`modified_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`is_deleted` TINYINT(4) NOT NULL DEFAULT '0' ,
`data` TEXT NOT NULL ,
PRIMARY KEY (`user_title_id`)) ENGINE = InnoDB;