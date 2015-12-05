CREATE TABLE `alertaopcion` (
  `IdOpcionAlerta` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`IdOpcionAlerta`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `alertaopcion`(`IdOpcionAlerta`,`Descripcion`) VALUES (1,'1 día')
, (2,'2 días')
, (3,'3 días')
, (4,'Siempre')
, (5,'No recordar');