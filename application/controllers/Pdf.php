<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once $_SERVER["DOCUMENT_ROOT"].'/convivir/application/libraries/FPDF.php';


class Pdf extends FPDF{
    
    public function __construct() {
          parent::__construct();
         
    }
    public function creaPdf ($alimentosVigentes) {
        $pdf = new FPDF();
        $image_height = 40;
        $image_width = 40;
        $pdf->SetFont('Times','',10);
        $pdf->AliasNbPages();
        $pdf->AddPage();
//      $pdf->Image('./assets/appconvivir/imagenes/logo-convivir.jpg', $pdf->GetX()+60, $pdf->GetY()); 
        
        $pdf->SetFont('Arial','B',16);
        $pdf->Ln(25);
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $pdf->SetTitle("LISTA DE ALIMENTOS CERTIFICADOS LIBRE DE GLUTEN");
        $pdf->SetLeftMargin(8);
        $pdf->SetRightMargin(8);
        $pdf->SetFillColor(200,200,200);
 
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $pdf->SetFont('Arial', 'B', 9);

        $pdf->Ln(1);
        $pdf->Cell(190,7,'LISTA DE ALIMENTOS CERTIFICADOS',1,0,'C');
        $pdf->Ln(7);
        //$date = new DateTime('2000-01-01');
        //setlocale(LC_TIME,'sp');
        echo date("d-m-Y H:i:s");
        $pdf->Cell(190,7,utf8_decode('Fecha de Actualización:  ').date("d") . " de " . $this->getMes(date("m")) . " del " . date("Y"),1,0,'L');
        
        //strftime("El año es %Y y el mes es %B")
        $pdf->Ln(7);
        $pdf->Cell(60,7,'SUBCATEGORIA','TBL',0,'L','1');
        $pdf->Cell(50,7,'EMPRESA','TB',0,'L','1');
        $pdf->Cell(80,7,'DESCRIPCION','TBR',0,'L','1');
        $pdf->Ln(7);
        //$this->algo();
        // La variable $x se utiliza para mostrar un número consecutivo
        $x = 1;
        foreach ($alimentosVigentes as $alimento) {
            // se imprime el numero actual y despues se incrementa el valor de $x en uno
            // Se imprimen los datos de cada alumno
            $pdf->Cell(50,5,utf8_decode($alimento->SubCategoria),'B',0,'L',0);
            $pdf->Cell(50,5,utf8_decode($alimento->Empresa),'B',0,'L',0);
            $pdf->Cell(80,5,utf8_decode($alimento->Descripcion),'B',0,'L',0);
            //Se agrega un salto de linea
            $pdf->Ln(5);
        }
        /*
         * Se manda el pdf al navegador
         * $this->pdf->Output(nombredelarchivo, destino);
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         */
        $pdf->Output("Lista de alumnos.pdf", 'I');
    }
    
    function getMes( $timestamp = 0 )
    {
	$timestamp = $timestamp == 0 ? time() : $timestamp;
	$meses = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	return $meses[date("n", $timestamp)];
    }
    
    function Header()
    {
        $pdf->Image('./assets/appconvivir/imagenes/logo-convivir.jpg', $pdf->GetX()+60, $pdf->GetY()); 
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'Title',1,0,'C');
        // Line break
        $this->Ln(20);
    }
    
    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
  
}
