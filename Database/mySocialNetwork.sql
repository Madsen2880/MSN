-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mysocialnetwork
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mysocialnetwork
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mysocialnetwork` DEFAULT CHARACTER SET utf8 ;
USE `mysocialnetwork` ;

-- -----------------------------------------------------
-- Table `mysocialnetwork`.`Pictures`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mysocialnetwork`.`Pictures` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Filename` VARCHAR(128) NOT NULL,
  `Title` VARCHAR(45) NULL,
  `PictureDesc` TEXT NULL,
  `Owner` INT NOT NULL,
  `DateAdded` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  INDEX `fk_Pictures_Users1_idx` (`Owner` ASC),
  CONSTRAINT `fk_Pictures_Users1`
    FOREIGN KEY (`Owner`)
    REFERENCES `mysocialnetwork`.`Users` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `mysocialnetwork`.`Users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mysocialnetwork`.`Users` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(64) NOT NULL,
  `Email` VARCHAR(128) NOT NULL,
  `Password` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `username_UNIQUE` (`Username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`Email` ASC))
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `mysocialnetwork`.`Userdetails`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mysocialnetwork`.`Userdetails` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ProfileText` TEXT NULL,
  `Firstname` VARCHAR(45) NULL,
  `Surname` VARCHAR(45) NULL,
  `Age` INT NULL,
  `DateCreated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Gender` VARCHAR(10) NULL,
  `Status` VARCHAR(45) NULL,
  `Employment` VARCHAR(64) NULL,
  `Hobbies` VARCHAR(256) NULL,
  `City` VARCHAR(45) NULL,
  `Country` VARCHAR(45) NULL,
  `ProfilePictureId` INT NULL,
  `UserId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `fk_UserId_idx` (`UserId` ASC),
  INDEX `fk_ProfilePicture_idx` (`ProfilePictureId` ASC),
  CONSTRAINT `fk_UserId`
    FOREIGN KEY (`UserId`)
    REFERENCES `mysocialnetwork`.`Users` (`Id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ProfilePicture`
    FOREIGN KEY (`ProfilePictureId`)
    REFERENCES `mysocialnetwork`.`Pictures` (`Id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mysocialnetwork`.`Posts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mysocialnetwork`.`Posts` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `DateCreated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateModified` DATETIME NULL,
  `Title` VARCHAR(45) NOT NULL,
  `SubmittedBy` VARCHAR(64) NOT NULL,
  `Post` TEXT NOT NULL,
  `Users_UserId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `fk_Posts_Users1_idx` (`Users_UserId` ASC),
  CONSTRAINT `fk_Posts_Users1`
    FOREIGN KEY (`Users_UserId`)
    REFERENCES `mysocialnetwork`.`Users` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mysocialnetwork`.`Friends`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mysocialnetwork`.`Friends` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `RequestDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `StatusConfirm` TINYINT(1) NOT NULL DEFAULT 0,
  `RelationStatus` VARCHAR(45) NULL,
  `UserOneId` INT NOT NULL,
  `UserTwoId` INT NOT NULL,
  `ConfirmDate` DATETIME NULL,
  PRIMARY KEY (`Id`),
  INDEX `fk_FriendOne_idx` (`UserOneId` ASC),
  INDEX `fk_FriendTwo_idx` (`UserTwoId` ASC),
  UNIQUE INDEX `UserOneId_UNIQUE` (`UserOneId` ASC),
  UNIQUE INDEX `UserTwoId_UNIQUE` (`UserTwoId` ASC),
  CONSTRAINT `fk_FriendOne`
    FOREIGN KEY (`UserOneId`)
    REFERENCES `mysocialnetwork`.`Users` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FriendTwo`
    FOREIGN KEY (`UserTwoId`)
    REFERENCES `mysocialnetwork`.`Users` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `mysocialnetwork`;

-- -----------------------------------------------------
-- Data for table `mysocialnetwork`.`Pictures`
-- -----------------------------------------------------
START TRANSACTION;
USE `mysocialnetwork`;
INSERT INTO `mysocialnetwork`.`Pictures` (`Id`, `Filename`, `Title`, `PictureDesc`, `Owner`, `DateAdded`) VALUES (1, 'avatar.jpg', 'Default Profile picture', 'Profile picture', 1, DEFAULT);

COMMIT;

DELIMITER $$
USE `mysocialnetwork`$$
CREATE DEFINER = CURRENT_USER TRIGGER `mysocialnetwork`.`Users_AFTER_INSERT` AFTER INSERT ON `Users` FOR EACH ROW
BEGIN
	INSERT INTO `mysocialnetwork`.`Userdetails` (ProfilePictureId, UserId)VALUES(1, NEW.Id);
END$$


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `mysocialnetwork`.`Users`
-- -----------------------------------------------------
START TRANSACTION;
USE `mysocialnetwork`;
INSERT INTO `mysocialnetwork`.`Users` (`Id`, `Username`, `Email`, `Password`) VALUES (1, 'System', 'admin@system.dk', '1234root');

COMMIT;




