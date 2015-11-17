<html>

<?php require 'head.php'; ?>
<body>
		<header class="cabecera">
			 <?php require_once 'logo.php';?>
		</header>
<div class="cabecera-menu">
		<ul>
                    <?php  require 'menu.php'; ?>
		</ul>
</div>
		<?php require_once 'sesionSection.php'?>
		<div class="main-content">
			<div class="contenedor-blanco">
			 <?php echo $output; ?>
			</div>
		</div>
    <?php
if(isset($dropdown_setup)) {
	$this->load->view('dependent_dropdown', $dropdown_setup);
}
?>
	</body>
</html>