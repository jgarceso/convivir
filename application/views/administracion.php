<html>

<?php require 'head.php'; ?>
<body>
		<header class="cabecera">
			 <?php require_once 'logo.php';?>
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
                                <?php
                                echo '<a href="'.$this->config->site_url().'CerrarSesion" class="icon-salir" title="Cerrar Sesión"></a>';
                                echo '<a href="'.$this->config->site_url().'Administracion" class="icon-inicio" title="Inicio"></a>'
                                ?>
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