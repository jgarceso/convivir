CREATE TABLE `producto` (
  `IdProducto` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(8000) NOT NULL,
  `IdTipo` int(11) NOT NULL,
  `IdSubcategoria` int(11) NOT NULL,
  `IdEmpresa` int(11) NOT NULL,
  `IdCategoria` int(11) NOT NULL,
  `IdEstadoCertificacion` int(11) DEFAULT NULL,
  `UsuarioModifica` varchar(200) DEFAULT NULL,
  `FechaModificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`IdProducto`),
  KEY `producto_ibfk_1` (`IdTipo`),
  KEY `producto_ibfk_2` (`IdSubcategoria`),
  KEY `producto_ibfk_3` (`IdEmpresa`),
  KEY `producto_ibfk_4` (`IdCategoria`),
  KEY `producto_ibfk_5` (`IdEstadoCertificacion`),
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`IdTipo`) REFERENCES `tipoproducto` (`IdTipo`),
  CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`IdSubcategoria`) REFERENCES `subcategoriaproducto` (`IdSubcategoria`),
  CONSTRAINT `producto_ibfk_3` FOREIGN KEY (`IdEmpresa`) REFERENCES `empresa` (`IdEmpresa`),
  CONSTRAINT `producto_ibfk_4` FOREIGN KEY (`IdCategoria`) REFERENCES `categoriaproducto` (`IdCategoria`),
  CONSTRAINT `producto_ibfk_5` FOREIGN KEY (`IdEstadoCertificacion`) REFERENCES `estadocertificacion` (`IdEstadoCertificacion`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

