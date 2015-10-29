CREATE TABLE `producto_log` (
  `IdProducto` int(11) NOT NULL,
  `Descripcion` varchar(8000) NOT NULL,
  `IdTipo` int(11) NOT NULL,
  `IdSubcategoria` int(11) NOT NULL,
  `IdEmpresa` int(11) NOT NULL,
  `IdCategoria` int(11) NOT NULL,
  `IdEstadoCertificacion` int(11) NOT NULL,
  `UsuarioModifica` varchar(200) DEFAULT 'anonymous',
  `FechaModificacion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `Accion` varchar(50) DEFAULT NULL,
  KEY `IdTipo_log` (`IdTipo`),
  KEY `IdSubcategoria_log` (`IdSubcategoria`),
  KEY `IdEmpresa_log` (`IdEmpresa`),
  KEY `IdCategoria_log` (`IdCategoria`),
  KEY `IdEstadoCertificacion_log` (`IdEstadoCertificacion`),
  CONSTRAINT `producto_ibfk_1_log` FOREIGN KEY (`IdTipo`) REFERENCES `tipoproducto` (`IdTipo`),
  CONSTRAINT `producto_ibfk_2_log` FOREIGN KEY (`IdSubcategoria`) REFERENCES `subcategoriaproducto` (`IdSubcategoria`),
  CONSTRAINT `producto_ibfk_3_log` FOREIGN KEY (`IdEmpresa`) REFERENCES `empresa` (`IdEmpresa`),
  CONSTRAINT `producto_ibfk_4_log` FOREIGN KEY (`IdCategoria`) REFERENCES `categoriaproducto` (`IdCategoria`),
  CONSTRAINT `producto_ibfk_5_log` FOREIGN KEY (`IdEstadoCertificacion`) REFERENCES `estadocertificacion` (`IdEstadoCertificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



