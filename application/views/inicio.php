<html>

<?php require 'head.php'; ?>
<body>
		<header class="cabecera">
			 <?php require_once 'logo.php';?>
		</header>
<div class="cabecera-menu">
		<ul>
                    <?php
                    require 'menu.php';
                    ?>
		</ul>
</div>
		<?php require_once 'sesionSection.php'?>
		<div class="main-content">
			<div class="contenedor-blanco">                  
                            <h1 class="inicio-titulo">Portal de Administración de Productos Certificados</h1>
                            <div style="width:40%;float:left;overflow: hidden;height: 80%;">
                                <?php
                                echo '<img style="width:100%;height:100%;" src="'.$this->config->site_url().$this->convivir->imagenes_path.'convivir-portada.png" />';
                                ?>
                            </div>
                            <div style="width:50%;float:left;">
                            <p style="line-height: 1.5;">
                                Usted se encuentra en el portal de administración. Aquí podrá encontrar diversos mantenedores para poder registrar cambios en la información 
                                relacionada a los productos certificados. Para mayor detalle respecto al proceso, consulte el manual de usuario que se puede descargar del siguiente enlace:
                                <br><br><a href="#">Descargar Manual de Usuario</a>
                            </p>
                            </div>
			</div>
		</div>
	</body>
</html>