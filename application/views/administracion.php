<html>
<head>
	<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

        <link rel="stylesheet" href="/convivir/assets/appconvivir/css/demo.css">
		<link rel="stylesheet" href="/convivir/assets/appconvivir/css/convivir.css">
		<link rel="stylesheet" href="/convivir/assets/appconvivir/css/form-validation.css">
</head>

<body>
		<header class="cabecera">
			<img src="/convivir/assets/appconvivir/imagenes/logo-convivir.jpg" />
		</header>
<div class="cabecera-menu">
		<ul>
			<li>
				<a href="administracion" class="active">Productos</a>
			</li>
			<li>
				<a href="#">Categorias</a>
			</li>
			<li>
				<a href="#">Empresas</a>
			</li>
		</ul>
</div>
		<div class="contenedor-user-info">
			<div class="user-info">
				<span class="user-icon"></span><?php echo $_SESSION["usuario"] ?>				
				<a href="CerrarSesion" class="icon-salir" title="Cerrar Sesión"></a>
				<a href="administracion" class="icon-inicio" title="Inicio"></a>
			</div>
			<div></div>
		</div>
		<div class="main-content">
			<div class="contenedor-blanco">
			 <?php echo $output; ?>
			</div>
		</div>
	</body>
</html>
