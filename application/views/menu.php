<?php

$menuOptions = array(
    array(
        'displayName'=>'Inicio',
        'controller'=>'Inicio'
        ),
    array(
        'displayName'=>'Productos',
        'controller'=>'Productos'
        ),
    array(
        'displayName'=>'Categorías',
        'controller'=>'Categorias'
        ),
    array(
        'displayName'=>'SubCategorías',
        'controller'=>'SubCategorias'
        ),
    array(
         
        'displayName'=>'Empresas',
        'controller'=>'Empresas'          
        ),
    array(
        'displayName'=>'Lugares de Interés',
        'controller'=>'PuntosVenta'
        ),
    array(
        'displayName'=>'Log Productos',
        'controller'=>'LogProductos'
        ),
		
    );
        
        
    foreach ($menuOptions as $item){
        $cssClass = "";
              			
        if($item['controller'] == $this->controllerName)
        {
            $cssClass ='class="active"';
        }
        echo '<li>';
        echo '<a href="'.$this->config->site_url().$item['controller'].'" '.$cssClass.'>'.$item['displayName'].'</a>';
        echo '</li>';
    }
?>

