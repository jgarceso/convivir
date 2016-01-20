<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'BaseController.php';

class Excel extends CI_Controller {
    
     const VIGENTE = 1;  
     const RENOVACION = 3;  
     const CADUCADO = 2;  
     
     const TIPO_ALIMENTOS = 1;  
     const TIPO_MEDICAMENTOS = 2;  
     
     const HOJA_ALIMENTOS = 0;
     const HOJA_MEDICAMENTOS = 1;
     
   
    public function __construct () {
        parent::__construct();
         
        // inicializamos la librería
        $this->load->library('PHPExcel.php');
    }
    public function index () {
        try{
            $this->load->model('Excel_model');
         
            // configuramos las propiedades del documento
            $this->phpexcel->getProperties()->setCreator("Arkos Noem Arenom")
                                         ->setLastModifiedBy("Arkos Noem Arenom")
                                         ->setTitle("Office 2007 XLSX Test Document")
                                         ->setSubject("Office 2007 XLSX Test Document")
                                         ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                         ->setKeywords("office 2007 openxml php")
                                         ->setCategory("Test result file");

             // obtenemos las categorias de alimentos
             // $categoriasAlimentos=$this->Excel_model->get_CategoriasxTipo(1);
             // obtenemos medicamentos vigentes    
            $alimentosVigentes=$this->Excel_model->get_ProductosxTipo(self::TIPO_ALIMENTOS,self::VIGENTE);

            $fila=6;
                foreach( $alimentosVigentes as $llave){
                    
                    if($fila==6){
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)
                       //se despiega el titulo
                        ->setCellValue('B2', 'PRODUCTOS CON CERTIFICACION VIGENTE');
                        //se aplica rowspan
                        $this->phpexcel->getActiveSheet()->mergeCells('B2:E2');
                        //se aplica color a al titulo seccion principal verde
                        $this->phpexcel->getActiveSheet()->getStyle('A2:B2')->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('AFE495');
                        $this->phpexcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
                        
                        //se agrega subtitulo
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)
                        ->setCellValue('B3', 'SUBCATEGORIA')
                        ->setCellValue('C3', 'DESCRIPCION')
                        ->setCellValue('D3', 'CATEGORIA')
                        ->setCellValue('E3', 'EMPRESA');
                        //Se aplica negrita al subtitulo
                        $this->phpexcel->getActiveSheet()->getStyle('B3:E3')->getFont()->setBold(true);
                        
                        //SE AGREGA CATEGORIA
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)
                        ->setCellValue('B4', 'CATEGORIA:  '.$llave->Categoria);
                        //se aplica rowspan
                        $this->phpexcel->getActiveSheet()->mergeCells('B4:E4');
                        //se aplica color y negrita a las categorias
                         $this->phpexcel->getActiveSheet()->getStyle('B4')->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                         $this->phpexcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
                         
                        //se aplica color al costado verde
                        $this->phpexcel->getActiveSheet()->getStyle('A2:A4')->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('AFE495');
                         $IdCategoria = $llave->IdCategoria;  
                         
                        $this->phpexcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30); 
                        $this->phpexcel->getActiveSheet()->getRowDimension('4')->setRowHeight(25);  
                    }
                     //desplegamos los productos por cada categoría 
                    if($IdCategoria===$llave->IdCategoria){  
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                        
                        //se aplica color al costado verde
                        $this->phpexcel->getActiveSheet()->getStyle('A'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('AFE495');
                         $IdCategoria = $llave->IdCategoria;  
                        
                    }else{
                        $IdCategoria = $llave->IdCategoria;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)   
                        ->setCellValue('B'.$fila, 'CATEGORIA:  '.$llave->Categoria);    
                         //se aplica color a las categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.$fila.':E'.$fila);
                        
                        //se define un ancho para la celda
                        $this->phpexcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(25);
                        
                        //se aplica color al costado verde
                        $this->phpexcel->getActiveSheet()->getStyle('A'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('AFE495');
                        
                        $fila=$fila+1;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                        
                        //se aplica color al costado verde
                        $this->phpexcel->getActiveSheet()->getStyle('A'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('AFE495');
                        
                         $IdCategoria = $llave->IdCategoria;  
                    }
                    $fila=$fila+1;
            }
            //FIN LOGICA PARA MOSTRAR PRODUCTOS VIGENTES
            //INICIO LOGICA PARA ALIMENTOS EN RENOVACION
            $crearTitulos=false;
            $alimentosEnRenovacion=$this->Excel_model->get_ProductosxTipo(self::TIPO_ALIMENTOS,self::RENOVACION);  
                foreach( $alimentosEnRenovacion as $llave){
                    
                   // Si la cabecera no esta creada debe crearse
                    if(!$crearTitulos){
                        //se crea titulo de la seccion
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)
                            ->setCellValue('B'.($fila+1), 'PRODUCTOS EN RENOVACION DE CERTIFICACION.'); 
                        
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.($fila+1).':E'.($fila+1));
                        //se coloca color de fondo amarillo
                        $this->phpexcel->getActiveSheet()->getStyle('A'.($fila+1).':B'.($fila+1))->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('ECFF6E');
                        
                        //se aplica negrita
                        $this->phpexcel->getActiveSheet()->getStyle('B'.($fila+1).':E'.($fila+1))->getFont()->setBold(true);
                        
                        $fila=$fila+2;
                        
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)
                                       ->setCellValue('B'.$fila, 'SUBCATEGORIA')
                                       ->setCellValue('C'.$fila, 'DESCRIPCION')
                                       ->setCellValue('D'.$fila, 'CATEGORIA')
                                       ->setCellValue('E'.$fila, 'EMPRESA');
                        
                        //se aplica negrita a subtitulo
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila.':E'.$fila)->getFont()->setBold(true);
                        $fila=$fila+1;
                        //agregamos la descripcion de categorias
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)
                                       ->setCellValue('B'.$fila, 'CATEGORIA:  '.$llave->Categoria);
                        //se aplica negrita a las categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
                        //se aplica color a las categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                        //se coloca el color amarillo al costado de las cabeceras
                        $this->phpexcel->getActiveSheet()->getStyle('A'.($fila-1).':A'.$fila)->getFill()
                                                         ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                                         ->getStartColor()->setRGB('ECFF6E');
                        
                        //se aplica rowspan a las categorias
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.$fila.':E'.$fila);
                        $IdCategoria = $llave->IdCategoria;
                        $crearTitulos=true;
                        $fila=$fila+1;
                    }
                      
                    if($IdCategoria===$llave->IdCategoria){  
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                        //se coloca el color amarillo al costado de los productos
                        $this->phpexcel->getActiveSheet()->getStyle('A'.$fila)->getFill()
                                                         ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                                         ->getStartColor()->setRGB('ECFF6E');
                        
                    }else{
                        $IdCategoria = $llave->IdCategoria;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)   
                        ->setCellValue('B'.$fila, 'CATEGORIA:  '.$llave->Categoria);    
                         //se aplica color a las categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.$fila.':E'.$fila);
                        
                        //se coloca el color amarillo al costado de los alimentos
                        $this->phpexcel->getActiveSheet()->getStyle('A'.$fila)->getFill()
                                                         ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                                         ->getStartColor()->setRGB('ECFF6E');
                        
                        $fila=$fila+1;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                        
                        //se coloca el color amarillo al costado de los alimentos
                        $this->phpexcel->getActiveSheet()->getStyle('A'.$fila)->getFill()
                                                         ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                                         ->getStartColor()->setRGB('ECFF6E');
                    }
                    $fila=$fila+1;
            } 
            //FIN LOGICA PARA MOSTRAR PRODUCTOS EN RENOVACION
            //INICIO LOGICA PARA ALIMENTOS CADUCADOS
            $crearTitulos=false;
            $alimentosCaducados=$this->Excel_model->get_ProductosxTipo(self::TIPO_ALIMENTOS,self::CADUCADO);  
                foreach( $alimentosCaducados as $llave){
                   // Si la cabecera no esta creada debe crearse
                    if(!$crearTitulos){
                        //se crea titulo de la seccion
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)
                            ->setCellValue('B'.($fila+1), 'PRODUCTOS SIN CERTIFICACIÓN.'); 
                        
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.($fila+1).':E'.($fila+1));
                        //se coloca color de fondo rojo
                        $this->phpexcel->getActiveSheet()->getStyle('B'.($fila+1))->getFill()
                                                         ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                                         ->getStartColor()->setRGB('F73737');
                        
                        //se coloca color de fondo rojo al costado
                        $this->phpexcel->getActiveSheet()->getStyle('A'.($fila+1).':A'.($fila+3))->getFill()
                                                         ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                                         ->getStartColor()->setRGB('F73737');
                        //se aplica negrita
                        $this->phpexcel->getActiveSheet()->getStyle('B'.($fila+1).':E'.($fila+1))->getFont()->setBold(true);
                        $fila=$fila+2;
                        
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)
                                       ->setCellValue('B'.$fila, 'SUBCATEGORIA')
                                       ->setCellValue('C'.$fila, 'DESCRIPCION')
                                       ->setCellValue('D'.$fila, 'CATEGORIA')
                                       ->setCellValue('E'.$fila, 'EMPRESA');
                        
                        //se aplica negrita a subtitulo
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila.':E'.$fila)->getFont()->setBold(true);
                        $fila=$fila+1;
                        //agregamos la descripcion de categorias
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)
                                       ->setCellValue('B'.$fila, 'CATEGORIA:  '.$llave->Categoria);
                        //se aplica negrita a las categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
                        //se aplica color a las categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                        
                        //se aplica rowspan a las categorias
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.$fila.':E'.$fila);
                        $IdCategoria = $llave->IdCategoria;
                        $crearTitulos=true;
                        $fila=$fila+1;
                    }
                      
                    if($IdCategoria===$llave->IdCategoria){  
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                        //se aplica color rojo al costado
                        $this->phpexcel->getActiveSheet()->getStyle('A'.$fila)->getFill()
                                                         ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                                         ->getStartColor()->setRGB('F73737');
                        
                    }else{
                        $IdCategoria = $llave->IdCategoria;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)   
                        ->setCellValue('B'.$fila, 'CATEGORIA:  '.$llave->Categoria);    
                         //se aplica color a lass categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.$fila.':E'.$fila);
                        
                        //se aplica color rojo al costado
                        $this->phpexcel->getActiveSheet()->getStyle('A'.$fila)->getFill()
                                                         ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                                         ->getStartColor()->setRGB('F73737');
                        
                        $fila=$fila+1;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                        
                        //se aplica color rojo al costado
                        $this->phpexcel->getActiveSheet()->getStyle('A'.$fila)->getFill()
                                                         ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                                         ->getStartColor()->setRGB('F73737');
                    }
                    $fila=$fila+1;
            } 
            //FIN LOGICA PARA MOSTRAR PRODUCTOS EN RENOVACION
              
            // Renombramos la hoja de trabajo
            $this->phpexcel->getActiveSheet()->setTitle('Alimentos');
            $this->phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
            $this->phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $this->phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(70);
            $this->phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $this->phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
            
        //////////////////////////////CREAMOS UNA NUEVA HOJA PARA LOS MEDICAMENTOS
            
            $this->phpexcel->createSheet();//creamos la pestaña
             // obtenemos MEDICAMENTOS vigentes    
            $medicamentosVigentes=$this->Excel_model->get_ProductosxTipo(self::TIPO_MEDICAMENTOS,self::VIGENTE);
            $fila=6;
            if(count($medicamentosVigentes)>0){
                 foreach( $medicamentosVigentes as $llave){
                    
                    if($fila==6){
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                       //se despiega el titulo
                        ->setCellValue('B2', 'LISTA DE MEDICAMENTOS CON CERTIFICACION VIGENTE');
                        //se aplica rowspan
                        $this->phpexcel->getActiveSheet()->mergeCells('B2:E2');
                        //se aplica color a al titulo seccion principal verde
                        $this->phpexcel->getActiveSheet()->getStyle('B2')->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('AFE495');
                        $this->phpexcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
                        
                        //se agrega subtitulo
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                        ->setCellValue('B3', 'SUBCATEGORIA')
                        ->setCellValue('C3', 'DESCRIPCION')
                        ->setCellValue('D3', 'CATEGORIA')
                        ->setCellValue('E3', 'EMPRESA');
                        //Se aplica negrita al subtitulo
                        $this->phpexcel->getActiveSheet()->getStyle('B3:E3')->getFont()->setBold(true);
                        
                        //SE AGREGA CATEGORIA
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                        ->setCellValue('B4', 'CATEGORIA:  '.$llave->Categoria);
                        //se aplica rowspan
                        $this->phpexcel->getActiveSheet()->mergeCells('B4:E4');
                        //se aplica color y negrita a las categorias
                         $this->phpexcel->getActiveSheet()->getStyle('B4')->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                         $this->phpexcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
                         $IdCategoria = $llave->IdCategoria;  
                    }
                     //desplegamos los productos por cada categoría 
                    if($IdCategoria===$llave->IdCategoria){  
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                        
                    }else{
                        $IdCategoria = $llave->IdCategoria;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)   
                        ->setCellValue('B'.$fila, 'CATEGORIA:  '.$llave->Categoria);    
                         //se aplica color a las categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.$fila.':E'.$fila);
                        
                        $fila=$fila+1;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                    }
                    $fila=$fila+1;
                }
            }else{
                $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                                ->setCellValue('B'.($fila+1), 'NO EXISTEN MEDICAMENTOS CON CERTIFICACIÓN VIGENTE.'); 
            }
            //FIN LOGICA PARA MOSTRAR MEDICAMENTOS VIGENTES
            //INICIO LOGICA PARA MEDICAMENTOS EN RENOVACION
            $crearTitulos=false;
            $medicamentosEnRenovacion=$this->Excel_model->get_ProductosxTipo(self::TIPO_MEDICAMENTOS,  self::RENOVACION);  
             if(count($medicamentosEnRenovacion)>0){
                 foreach($medicamentosEnRenovacion as $llave){
                    
                   // Si la cabecera no esta creada debe crearse
                    if(!$crearTitulos){
                        //se crea titulo de la seccion
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                            ->setCellValue('B'.($fila+1), 'PRODUCTOS EN RENOVACION DE CERTIFICACION.'); 
                        
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.($fila+1).':E'.($fila+1));
                        //se coloca color de fondo amarillo
                        $this->phpexcel->getActiveSheet()->getStyle('B'.($fila+1))->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('ECFF6E');
                        //se aplica negrita
                        $this->phpexcel->getActiveSheet()->getStyle('B'.($fila+1).':E'.($fila+1))->getFont()->setBold(true);
                        $fila=$fila+2;
                        
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                                       ->setCellValue('B'.$fila, 'SUBCATEGORIA')
                                       ->setCellValue('C'.$fila, 'DESCRIPCION')
                                       ->setCellValue('D'.$fila, 'CATEGORIA')
                                       ->setCellValue('E'.$fila, 'EMPRESA');
                        
                        //se aplica negrita a subtitulo
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila.':E'.$fila)->getFont()->setBold(true);
                        $fila=$fila+1;
                        //agregamos la descripcion de categorias
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                                       ->setCellValue('B'.$fila, 'CATEGORIA:  '.$llave->Categoria);
                        //se aplica negrita a las categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
                        //se aplica color a las categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                        
                        //se aplica rowspan a las categorias
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.$fila.':E'.$fila);
                        $IdCategoria = $llave->IdCategoria;
                        $crearTitulos=true;
                        $fila=$fila+1;
                    }
                      
                    if($IdCategoria===$llave->IdCategoria){  
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                        
                    }else{
                        $IdCategoria = $llave->IdCategoria;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)   
                        ->setCellValue('B'.$fila, 'CATEGORIA:  '.$llave->Categoria);    
                         //se aplica color a lass categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.$fila.':E'.$fila);
                        
                        $fila=$fila+1;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                    }
                    $fila=$fila+1;
                 } 
             }else{
                $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                                ->setCellValue('B'.($fila+1), 'NO EXISTEN MEDICAMENTOS EN RENOVACIÓN DE CERTIFICACIÓN.'); 
            }
                
            //FIN LOGICA PARA MOSTRAR PRODUCTOS EN RENOVACION
            //INICIO LOGICA PARA MEDICAMENTOS CADUCADOS
            $crearTitulos=false;
            $medicamentosCaducados=$this->Excel_model->get_ProductosxTipo(self::TIPO_MEDICAMENTOS,  self::CADUCADO);  
            
            if(count($medicamentosCaducados)>0){
                foreach($medicamentosCaducados as $llave){
                // Si la cabecera no esta creada debe crearse
                        if(!$crearTitulos){
                            //se crea titulo de la seccion
                            $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                                ->setCellValue('B'.($fila+1), 'MEDICAMENTOS SIN CERTIFICACIÓN.'); 
                            $fila=$fila+1;
                        }
                }
            }else{
                $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                                ->setCellValue('B'.($fila+1), 'NO EXISTEN MEDICAMENTOS SIN CERTFICACIÓN O CERTIFICACIÓN CADUCADA.'); 
            }
            //FIN LOGICA PARA MOSTRAR MEDICAMENTOS CADUCADOS
            
            // Renombramos la hoja de trabajo
            $this->phpexcel->getActiveSheet()->setTitle('Medicamentos');
            $this->phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
            $this->phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $this->phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(70);
            $this->phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $this->phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);

            // configuramos el documento para que la hoja
            // de trabajo número 0 sera la primera en mostrarse
            // al abrir el documento
            $this->phpexcel->setActiveSheetIndex(self::HOJA_ALIMENTOS);
            // La librería puede manejar la codificación de caracteres UTF-8
            // $this->phpexcel->setActiveSheetIndex(0)
            //  ->setCellValue('B4', 'Miscellaneous glyphs')
            //  ->setCellValue('B5', 'éàèùâêîôûëïüÿäöüç');

            // redireccionamos la salida al navegador del cliente (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Cache-Control: max-age=0'); 
            header('Content-Disposition: attachment;filename="listado.xlsx"');

            $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
            $objWriter->save('php://output');
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
    }
    
    public function creaHojaMedicamentos(){
        $this->phpexcel->createSheet();//creamos la pestaña
             // obtenemos MEDICAMENTOS vigentes    
            $alimentosVigentes=$this->Excel_model->get_ProductosxTipo(self::TIPO_MEDICAMENTOS,self::VIGENTE);
            $fila=6;
                foreach( $alimentosVigentes as $llave){
                    
                    if($fila==6){
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                       //se despiega el titulo
                        ->setCellValue('B2', 'PRODUCTOS CON CERTIFICACION VIGENTE');
                        //se aplica rowspan
                        $this->phpexcel->getActiveSheet()->mergeCells('B2:E2');
                        //se aplica color a al titulo seccion principal verde
                        $this->phpexcel->getActiveSheet()->getStyle('B2')->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('AFE495');
                        $this->phpexcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
                        
                        //se agrega subtitulo
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                        ->setCellValue('B3', 'SUBCATEGORIA')
                        ->setCellValue('C3', 'DESCRIPCION')
                        ->setCellValue('D3', 'CATEGORIA')
                        ->setCellValue('E3', 'EMPRESA');
                        //Se aplica negrita al subtitulo
                        $this->phpexcel->getActiveSheet()->getStyle('B3:E3')->getFont()->setBold(true);
                        
                        //SE AGREGA CATEGORIA
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                        ->setCellValue('B4', 'CATEGORIA:  '.$llave->Categoria);
                        //se aplica rowspan
                        $this->phpexcel->getActiveSheet()->mergeCells('B4:E4');
                        //se aplica color y negrita a las categorias
                         $this->phpexcel->getActiveSheet()->getStyle('B4')->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                         $this->phpexcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
                         $IdCategoria = $llave->IdCategoria;  
                    }
                     //desplegamos los productos por cada categoría 
                    if($IdCategoria===$llave->IdCategoria){  
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                        
                    }else{
                        $IdCategoria = $llave->IdCategoria;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)   
                        ->setCellValue('B'.$fila, 'CATEGORIA:  '.$llave->Categoria);    
                         //se aplica color a las categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.$fila.':E'.$fila);
                        
                        $fila=$fila+1;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                    }
                    $fila=$fila+1;
            }
            //FIN LOGICA PARA MOSTRAR MEDICAMENTOS VIGENTES
            //INICIO LOGICA PARA MEDICAMENTOS EN RENOVACION
            $crearTitulos=false;
            $medicamentosEnRenovacion=$this->Excel_model->get_ProductosxTipo(self::TIPO_MEDICAMENTOS,  self::RENOVACION);  
                foreach( $medicamentosEnRenovacion as $llave){
                    
                   // Si la cabecera no esta creada debe crearse
                    if(!$crearTitulos){
                        //se crea titulo de la seccion
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                            ->setCellValue('B'.($fila+1), 'PRODUCTOS EN RENOVACION DE CERTIFICACION.'); 
                        
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.($fila+1).':E'.($fila+1));
                        //se coloca color de fondo amarillo
                        $this->phpexcel->getActiveSheet()->getStyle('B'.($fila+1))->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('ECFF6E');
                        //se aplica negrita
                        $this->phpexcel->getActiveSheet()->getStyle('B'.($fila+1).':E'.($fila+1))->getFont()->setBold(true);
                        $fila=$fila+2;
                        
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                                       ->setCellValue('B'.$fila, 'SUBCATEGORIA')
                                       ->setCellValue('C'.$fila, 'DESCRIPCION')
                                       ->setCellValue('D'.$fila, 'CATEGORIA')
                                       ->setCellValue('E'.$fila, 'EMPRESA');
                        
                        //se aplica negrita a subtitulo
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila.':E'.$fila)->getFont()->setBold(true);
                        $fila=$fila+1;
                        //agregamos la descripcion de categorias
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                                       ->setCellValue('B'.$fila, 'CATEGORIA:  '.$llave->Categoria);
                        //se aplica negrita a las categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
                        //se aplica color a las categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                        
                        //se aplica rowspan a las categorias
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.$fila.':E'.$fila);
                        $IdCategoria = $llave->IdCategoria;
                        $crearTitulos=true;
                        $fila=$fila+1;
                    }
                      
                    if($IdCategoria===$llave->IdCategoria){  
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                        
                    }else{
                        $IdCategoria = $llave->IdCategoria;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)   
                        ->setCellValue('B'.$fila, 'CATEGORIA:  '.$llave->Categoria);    
                         //se aplica color a lass categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.$fila.':E'.$fila);
                        
                        $fila=$fila+1;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                    }
                    $fila=$fila+1;
            } 
            //FIN LOGICA PARA MOSTRAR PRODUCTOS EN RENOVACION
            //INICIO LOGICA PARA ALIMENTOS CADUCADOS
            $crearTitulos=false;
            $medicamentosCaducados=$this->Excel_model->get_ProductosxTipo(self::TIPO_MEDICAMENTOS,  self::CADUCADO);  
                foreach( $medicamentosCaducados as $llave){
                   // Si la cabecera no esta creada debe crearse
                    if(!$crearTitulos){
                        //se crea titulo de la seccion
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                            ->setCellValue('B'.($fila+1), 'PRODUCTOS SIN CERTIFICACIÓN.'); 
                        
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.($fila+1).':E'.($fila+1));
                        //se coloca color de fondo rojo
                        $this->phpexcel->getActiveSheet()->getStyle('B'.($fila+1))->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('F73737');
                        //se aplica negrita
                        $this->phpexcel->getActiveSheet()->getStyle('B'.($fila+1).':E'.($fila+1))->getFont()->setBold(true);
                        $fila=$fila+2;
                        
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                                       ->setCellValue('B'.$fila, 'SUBCATEGORIA')
                                       ->setCellValue('C'.$fila, 'DESCRIPCION')
                                       ->setCellValue('D'.$fila, 'CATEGORIA')
                                       ->setCellValue('E'.$fila, 'EMPRESA');
                        
                        //se aplica negrita a subtitulo
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila.':E'.$fila)->getFont()->setBold(true);
                        $fila=$fila+1;
                        //agregamos la descripcion de categorias
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)
                                       ->setCellValue('B'.$fila, 'CATEGORIA:  '.$llave->Categoria);
                        //se aplica negrita a las categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
                        //se aplica color a las categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                        
                        //se aplica rowspan a las categorias
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.$fila.':E'.$fila);
                        $IdCategoria = $llave->IdCategoria;
                        $crearTitulos=true;
                        $fila=$fila+1;
                    }
                      
                    if($IdCategoria===$llave->IdCategoria){  
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                        
                    }else{
                        $IdCategoria = $llave->IdCategoria;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)   
                        ->setCellValue('B'.$fila, 'CATEGORIA:  '.$llave->Categoria);    
                         //se aplica color a lass categorias
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFill()
                                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('E7EBF9');
                        $this->phpexcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
                        $this->phpexcel->getActiveSheet()->mergeCells('B'.$fila.':E'.$fila);
                        
                        $fila=$fila+1;
                        $this->phpexcel->setActiveSheetIndex(self::HOJA_MEDICAMENTOS)   
                        ->setCellValue('B'.$fila, $llave->SubCategoria)
                        ->setCellValue('C'.$fila, $llave->Descripcion)
                        ->setCellValue('D'.$fila, $llave->Categoria)
                        ->setCellValue('E'.$fila, $llave->Empresa); 
                    }
                    $fila=$fila+1;
            } 
            //FIN LOGICA PARA MOSTRAR PRODUCTOS EN CADUCADOS
              

            // Renombramos la hoja de trabajo
            $this->phpexcel->getActiveSheet()->setTitle('Medicamentos');
            $this->phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
            $this->phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $this->phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(70);
            $this->phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $this->phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
    } 
    // end: setExcel
    
}
// end: excel
