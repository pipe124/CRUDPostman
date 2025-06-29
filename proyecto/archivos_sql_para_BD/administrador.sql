
-- -----------------------------------------------------
-- Table `tienda_canasta_familiar`.`administrador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tienda_canasta_familiar`.`administrador` (
  `ID_administrador` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL,
  `correo` VARCHAR(255) NOT NULL,
  `contraseña` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`ID_administrador`),
  UNIQUE INDEX `correo` (`correo` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;