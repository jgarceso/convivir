

CREATE TRIGGER producto_BI_Trigger 
AFTER INSERT ON producto FOR EACH ROW 
BEGIN 

INSERT INTO producto_log 
(IdProducto,Descripcion,IdTipo,IdSubcategoria,IdEmpresa,IdCategoria,IdEstadoCertificacion,UsuarioModifica, FechaModificacion, Accion ) 
VALUES (NEW.IdProducto, NEW.Descripcion,NEW.IdTipo, NEW.IdSubcategoria, NEW.IdEmpresa, NEW.IdCategoria, NEW.IdEstadoCertificacion,
NEW.UsuarioModifica, NEW.FechaModificacion, 'INGRESAR');

END

