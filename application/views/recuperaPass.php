<!DOCTYPE html>
<html>

<?php require_once 'head.php'; ?>
<body>
	<header class="cabecera" style="padding-bottom: 30px;">
             <?php require_once 'logo.php';?>
    </header>
    <div class="main-content">

        <form id="usuario-form" class="form-login" method="post" >

            <div class="form-log-in-with-email">

                <div class="form-white-background">

                    <div class="form-title-row">
                        <h1>Recupera contraseña</h1>
                    </div>

                    <div class="form-row">
                        <label>
                            <span>Introduce tu dirección de correo electrónico registrada y te enviaremos instrucciones de ayuda.</span>
                        </label>
                        <br/><br/><input id="input-usuario" type="text" name="email" maxlength="30" autocomplete="off" onpaste="return false;">                       
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
