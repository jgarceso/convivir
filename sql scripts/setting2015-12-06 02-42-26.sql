
USE convivir;

CREATE TABLE `setting` (
  `IdSetting` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) DEFAULT NULL,
  `Descripcion` varchar(500) DEFAULT NULL,
  `Valor` varchar(500) DEFAULT NULL,
  `TipoDato` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`IdSetting`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


INSERT INTO `setting`(`IdSetting`,`Nombre`,`Descripcion`,`Valor`,`TipoDato`) VALUES (1,'CantDiasCertificacion','Duración en días certificación de productos','365','INT')
, (2,'CantDiasAlertaVencimiento','Días previos aviso de vencimiento certificación','20','INT');

