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
                            <p>
                                Usted se encuentra en el portal de administración.
                            </p>
			</div>
		</div>
	</body>
</html>