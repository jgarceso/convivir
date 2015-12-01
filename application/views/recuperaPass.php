<!DOCTYPE html>
<html>

<?php require_once 'head.php'; ?>
<body>
	<header class="cabecera" style="padding-bottom: 30px;">
             <?php require_once 'logo.php';?>
    </header>
    <div class="main-content">
        <form id="newPass-form" class="form-login" method="post" >
            <div class="form-log-in-with-email">
                <div class="form-white-background">

                    <div class="form-title-row">
                        <h1>Recupera contraseña</h1>
                    </div>
                    <div class="form-row">
                        <label>
                            <span>Ingrese su nueva contraseña.</span>
                        </label>
                        <input id="input-newPass" type="password" name="newPass" maxlength="30" autocomplete="off" onpaste="return false;">                       
                    </div>
                    <div class="form-row">
                        <label>
                            <span>Confirme su nueva contraseña.</span>
                        </label>
                        <input id="input-newPassConfirm" type="password" name="newPassConfirm" maxlength="30" autocomplete="off" onpaste="return false;">                       
                    </div>
                  
                    <div class="form-row">
                        <button id="btn-newPass" type="button">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
