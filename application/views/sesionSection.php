<?php

echo '<div class="contenedor-user-info">';
		echo	'<div class="user-info">';
			echo	'<span class="user-icon" Id="icono-usuario"></span>'.$_SESSION["usuario"];

                                echo '<a href="'.$this->config->site_url().'Security/salir" class="icon-salir" title="Cerrar Sesión"></a>';
                                echo '<a href="'.$this->config->site_url().'Inicio" class="icon-inicio" title="Inicio"></a>';

		echo	'</div>';
		echo	'<div></div>';
	echo	'</div>';
