<!DOCTYPE html>
<html>

<?php require_once 'head.php'; ?>
<body>
	<header class="cabecera" style="padding-bottom: 30px;">
             <?php require_once 'logo.php';?>
    </header>
    <div class="main-content">
        <form id="email-form" class="form-login" method="post" >
            <div class="form-log-in-with-email">
                <div class="form-white-background">

                    <div class="form-title-row">
                        <h1>Recupera contraseña</h1>
                    </div>
                    <div class="form-row">
                        <label>
                            <span>Introduce tu dirección de correo electrónico y te enviaremos instrucciones de ayuda.</span>
                        </label>
                        <br/><br/><input id="input-email" type="text" name="email" maxlength="60" autocomplete="off" onpaste="return true;">                       
                    </div>
                    <div class="form-row">
                        <button id="btn-email" type="button">Enviar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
