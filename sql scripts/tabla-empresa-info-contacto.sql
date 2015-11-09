CREATE TABLE `empresa` (
  `IdEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(512) NOT NULL,
  `NombreContacto` varchar(1000) NOT NULL,
  `EmailContacto` varchar(256) NOT NULL,
  `TelefonoContacto` int(11) NOT NULL,
  PRIMARY KEY (`IdEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=230 DEFAULT CHARSET=latin1;

