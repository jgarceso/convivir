<?php 
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Login Form</title>

	<link rel="stylesheet" href="assets/appconvivir/css/demo.css">
	<link rel="stylesheet" href="assets/appconvivir/css/form-login.css">
	<script type="text/javascript" src="assets/appconvivir/js/lib/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="assets/appconvivir/js/lib/jquery.validate.min.js"></script>
	<script type="text/javascript" src="assets/appconvivir/js/archivos/app.js"></script>
	
</head>

<body>
	<header class="cabecera" style="padding-bottom: 30px;">
		<img src="assets/appconvivir/imagenes/logo-convivir.jpg" />
    </header>


    <div class="main-content">

        <form id="login-form" class="form-login" method="post" >

            <div class="form-log-in-with-email">

                <div class="form-white-background">

                    <div class="form-title-row">
                        <h1>Iniciar Sesión</h1>
                    </div>

                    <div class="form-row">
                        <label>
                            <span>Usuario</span>
                        </label>
                        <input id="input-usuario" type="text" name="usuario" maxlength="30" autocomplete="off" onpaste="return false;">
                        
                    </div>

                    <div class="form-row">
                        <label>
                            <span>Password</span>
                            <input id="input-password" type="password" name="password" maxlength="30" onpaste="return false;">
                        </label>
                    </div>

                    <div class="form-row">
                        <button id="btn-login" type="button">Log in</button>
                    </div>

                </div>

            </div>

        </form>

    </div>

</body>

</html>
