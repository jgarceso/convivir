CREATE TABLE `puntoventa` (
  `IdPuntoVenta` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(5000) NOT NULL,
  `Direccion` varchar(5000) NOT NULL,
  `IdRegion` int(11) NOT NULL,
  `IdProvincia` int(11) NOT NULL,
  `IdComuna` int(11) NOT NULL, 
  `Latitud` float(10,8) NOT NULL,
  `Longitud` float (10,8) NOT NULL,
  PRIMARY KEY (`IdPuntoVenta`),
  KEY `puntoventa_ibfk_1` (`IdComuna`),
  KEY `puntoventa_ibfk_2` (`IdProvincia`),
  KEY `puntoventa_ibfk_3` (`IdRegion`),
  CONSTRAINT `puntoventa_ibfk_1` FOREIGN KEY (`IdComuna`) REFERENCES `comuna` (`IdComuna`),
  CONSTRAINT `puntoventa_ibfk_2` FOREIGN KEY (`IdProvincia`) REFERENCES `provincia` (`IdProvincia`),
  CONSTRAINT `puntoventa_ibfk_3` FOREIGN KEY (`IdRegion`) REFERENCES `region` (`IdRegion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

