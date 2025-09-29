CREATE TABLE `mechxweightdb`.`parties` (`parties_id` INT NOT NULL AUTO_INCREMENT , `party_name` VARCHAR(100) NOT NULL , `party_email` VARCHAR(50) NOT NULL , `party_phone` VARCHAR(15) NOT NULL , `party_status` TINYINT NOT NULL , `party_created_at` DATE NOT NULL , PRIMARY KEY (`parties_id`)) ENGINE = InnoDB;

CREATE TABLE `mechxweightdb`.`vehicles` (`vehicle_id` INT NOT NULL AUTO_INCREMENT , `vehicle_owner` VARCHAR(100) NOT NULL , `vehicle_number` VARCHAR(10) NOT NULL , `vehicle_created_at` DATE NOT NULL , `vehicle_status` TINYINT NOT NULL , PRIMARY KEY (`vehicle_id`)) ENGINE = InnoDB;

ALTER TABLE `vehicles` ADD `vehicle_weight` INT NOT NULL AFTER `vehicle_status`;
ALTER TABLE `weights` ADD `material_id` INT NOT NULL AFTER `weightment_type`;
ALTER TABLE `parties` ADD UNIQUE(`party_email`);
ALTER TABLE `parties` CHANGE `parties_id` `party_id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `vehicles` ADD UNIQUE(`vehicle_number`);