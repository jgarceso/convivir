<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Provincias españolas en pdf</title>
    <style type="text/css">
        body {
         background-color: #fff;
         margin: 40px;
         font-family: Lucida Grande, Verdana, Sans-serif;
         font-size: 14px;
         color: #4F5155;
        }

        a {
         color: #003399;
         background-color: transparent;
         font-weight: normal;
        }

        h1 {
         color: #444;
         background-color: transparent;
         border-bottom: 1px solid #D0D0D0;
         font-size: 16px;
         font-weight: bold;
         margin: 24px 0 2px 0;
         padding: 5px 0 6px 0;
        }

        h2 {
         color: #F00;
         background-color: transparent;
         border-bottom: 1px solid #D0D0D0;
         font-size: 16px;
         font-weight: bold;
         margin: 24px 0 2px 0;
         padding: 5px 0 6px 0;
         text-align: center;
        }

        table{
            text-align: center;
            border: 1px #003399 double;
        }

        /* estilos para el footer y el numero de pagina */
        @page { margin: 180px 50px; }
        #header {
            position: fixed;
            left: 0px; top: -180px;
            right: 0px;
            height: 80px;
            background-color: #333;
            color: #fff;
            text-align: center;
        }
        #footer {
            position: fixed;
            left: 0px;
            bottom: -180px;
            right: 0px;
            height: 50px;
            background-color: #333;
            color: #fff;
        }
        #footer .page:after {
            content: counter(page, upper-roman);
        }
        .borde{
            border: 1px #003399;
        }
    </style>
</head>
<body>
    <!--header para cada pagina-->

    <h2>Categorias.</h2>
    <table class="borde">
        <thead>
            <tr>
                <th width="100">Iaad</th>
                <th width="400">Provincia</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categorias as $categoria) { ?>
            <tr>
                <td width="100"><?php echo $categoria->IdCategoria ?></td>
                <td width="400" ><?php echo $categoria->Nombre ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
