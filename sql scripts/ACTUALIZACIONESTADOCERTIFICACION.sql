
/*
ESTADO 2 = RENOVACION, ESTADO 3 = VENCIDA
2 = 85, 3 = 41*/

UPDATE producto
SET IdEstadoCertificacion = 3
where IdProducto >= 1157 AND IdProducto <= 1197;

UPDATE producto
SET IdEstadoCertificacion = 2
where IdProducto >= 1093 AND IdProducto <= 1156;

UPDATE producto
SET IdEstadoCertificacion = 2
where IdProducto >= 203 AND IdProducto <= 223;

UPDATE estadocertificacion
SET Nombre = 'En Renovación'
WHERE IdEstadoCertificacion = 2;

UPDATE estadocertificacion
SET Nombre = 'Vencida'
WHERE IdEstadoCertificacion = 3;
