

CREATE TABLE `region` (
  `IdRegion` int(11) NOT NULL COMMENT 'ID unico',
  `Descripcion` varchar(60) COLLATE latin1_spanish_ci NOT NULL COMMENT 'Nombre extenso',
  `NumRomano` varchar(5) COLLATE latin1_spanish_ci NOT NULL COMMENT 'Número de región',
  PRIMARY KEY (`IdRegion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Lista de regiones de Chile';



INSERT INTO `region` VALUES 	(1,'ARICA Y PARINACOTA','XV'),
								(2,'TARAPACÁ','I'),
								(3,'ANTOFAGASTA','II'),
								(4,'ATACAMA ','III'),
								(5,'COQUIMBO ','IV'),
								(6,'VALPARAÍSO ','V'),
								(7,'DEL LIBERTADOR GRAL. BERNARDO O\'HIGGINS ','VI'),
								(8,'DEL MAULE','VII'),
								(9,'DEL BIOBÍO ','VIII'),
								(10,'DE LA ARAUCANÍA','IX'),
								(11,'DE LOS RÍOS','XIV'),
								(12,'DE LOS LAGOS','X'),
								(13,'AISÉN DEL GRAL. CARLOS IBAÑEZ DEL CAMPO ','XI'),
								(14,'MAGALLANES Y DE LA ANTÁRTICA CHILENA','XII'),
								(15,'METROPOLITANA DE SANTIAGO','RM');