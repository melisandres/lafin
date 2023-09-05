
DROP TABLE IF EXISTS `mcandide_tag`.`writer` ;

CREATE TABLE IF NOT EXISTS `mcandide_tag`.`writer` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstName` VARCHAR(25) NULL,
  `LastName` VARCHAR(25) NULL,
  `email` VARCHAR(40) NOT NULL,
  `birthday` DATE NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tag`.`text`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mcandide_tag`.`text` ;

CREATE TABLE IF NOT EXISTS `mcandide_tag`.`text` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL,
  `constraint` VARCHAR(50) NULL,
  `note` VARCHAR(255) NULL,
  `writing` TEXT NULL,
  `writer_id` INT NOT NULL,
  `parent_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_text_writer_idx` (`writer_id` ASC),
  INDEX `fk_text_text1_idx` (`parent_id` ASC),
  CONSTRAINT `fk_text_writer`
    FOREIGN KEY (`writer_id`)
    REFERENCES `mcandide_tag`.`writer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_text_text1`
    FOREIGN KEY (`parent_id`)
    REFERENCES `mcandide_tag`.`text` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tag`.`keyword`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mcandide_tag`.`keyword` ;

CREATE TABLE IF NOT EXISTS `mcandide_tag`.`keyword` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `word` VARCHAR(30) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tag`.`text_has_keyword`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mcandide_tag`.`text_has_keyword` ;

CREATE TABLE IF NOT EXISTS `mcandide_tag`.`text_has_keyword` (
  `text_id` INT NOT NULL,
  `keywords_id` INT NOT NULL,
  PRIMARY KEY (`text_id`, `keywords_id`),
  INDEX `fk_text_has_keywords_keywords1_idx` (`keywords_id` ASC),
  INDEX `fk_text_has_keywords_text1_idx` (`text_id` ASC),
  CONSTRAINT `fk_text_has_keywords_text1`
    FOREIGN KEY (`text_id`)
    REFERENCES `mcandide_tag`.`text` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_text_has_keywords_keywords1`
    FOREIGN KEY (`keywords_id`)
    REFERENCES `mcandide_tag`.`keyword` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


