CREATE TABLE `alertaproducto` (
  `IdProducto` int(11) NOT NULL,
  `IdOpcionAlerta` int(11) DEFAULT '4',
  `FechaRecordatorio` date DEFAULT NULL,
  `FechaModificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`IdProducto`),
  KEY `IdOpcionAlerta` (`IdOpcionAlerta`),
  CONSTRAINT `alertaproducto_ibfk_1` FOREIGN KEY (`IdOpcionAlerta`) REFERENCES `alertaopcion` (`IdOpcionAlerta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

