-- Agregar a la base de datos dblibreria

CREATE TABLE IF NOT EXISTS `contacto` (
  `id`          INT(11)      NOT NULL AUTO_INCREMENT,
  `fecha`       DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre`      VARCHAR(100) NOT NULL,
  `correo`      VARCHAR(150) NOT NULL,
  `asunto`      VARCHAR(200) NOT NULL,
  `comentario`  TEXT         NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
