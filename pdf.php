<?php

require('fpdf/fpdf.php');
require_once 'classes/Cliente.php';
require_once 'classes/Direccion.php';
require_once 'classes/ConexionBD.php';
session_start();

class PDF extends FPDF {
// Cabecera de página
	function Header() {
	    // Logo
	    $this->Image("img/logo.jpg",10,20,50);
	    // Arial bold 15
	    $this->SetFont("Arial","B",15);
	    // Movernos a la derecha
	    $this->Cell(80);
	    // Salto de línea
	    $this->Ln(20);
	
	}
	
	// Pie de página
	function Footer() {
	    // Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont("Arial","I",8);
	    // Número de página
	    $this->Cell(0,10,"Page ".$this->PageNo()."/{nb}",0,0,"C");
	}
	// Funcion para imprimir texto
	function imprimirTexto($string,$wCelda,$hCelda,$tamLetra,$final) {
		$this->SetFont("Times","",$tamLetra);
		$this->Cell($wCelda,$hCelda,$string,0,$final);
	}
	//Funcion para generar la tabla con productos
	function listarProductos($titulo, $listaProductos) {
		//Cabecera
		foreach($titulo as $col)
			switch ($col){
				case "Nombre":
					$this->Cell(125,7,$col,1,0,'C');
					break;
				case "Cant.":
					$this->Cell(11,7,$col,1,0,'C');
					break;
				case "Precio Und.":
					$this->Cell(25,7,$col,1,0,'C');
					break;
				case "Precio":
					$this->Cell(25,7,$col,1,0,'C');
					break;
			}
			$this->Ln();
			
			foreach ($listaProductos as $detalle) {
				$this->Cell(125,5,$detalle["nombre"],1);
				$this->Cell(11,5,$detalle["cant"],1);
				$this->Cell(25,5,number_format($detalle["precio"],2,',','.').chr(128),1);
				$precio = $detalle["cant"] * $detalle["precio"];
				$this->Cell(25,5,number_format($precio,2,',','.').chr(128),1);
				$this->Ln();
			}
			if (count($listaProductos)<10) {
				for ($i = 0; $i<15; $i++) {
					$this->Cell(125,5,"",1);
					$this->Cell(11,5,"",1);
					$this->Cell(25,5,"",1);
					$this->Cell(25,5,"",1);
					$this->Ln();
				}
			}
			$this->Cell(125,5,"",1);
			$this->Cell(11,5,"",1);
			$this->SetFillColor(100,100,100);
			$this->Cell(25,5,"Total: ",1,0,'C',true);
			$this->Cell(25,5,number_format($detalle["total"],2,',','.').chr(128),1,1,'C',true);
	}
}

// Creación del objeto de la clase heredada
$conexion = new ConexionBD();
$cliente = $_SESSION["cliente"];
$id = $_GET["id"];
$listaDirecciones = $conexion->getDirecciones($cliente);
$listaProductos = $conexion->getDetallesFactura($id);

foreach ($listaDirecciones as $direccion) {
	if ($direccion->getTipo() == "env") {
		$dirEnvio = $direccion;
	} else {
		$dirfact = $direccion;
	}
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->imprimirTexto("Paseo La castellana, 50",140,3,8,0);
$pdf->imprimirTexto("Nro. Factura: $id",140,3,12,1);
$pdf->imprimirTexto("Madrid, 28000",0,3,8,1);
$pdf->imprimirTexto("Tel: 615000111",0,3,8,1);
$pdf->imprimirTexto("Email: info@electroshop.es",0,3,8,1);

$pdf->Ln(10);

$pdf->imprimirTexto("DATOS DEL CLIENTE",60,10,12,0);
$pdf->imprimirTexto("DIRECCION DE FACTURACION",70,10,12,0);
$pdf->imprimirTexto("DIRECCION DE ENTREGA",0,10,12,1);

$pdf->imprimirTexto("{$cliente->getNombre()} {$cliente->getApellidos()}",60,5,12,0);
$pdf->imprimirTexto("{$dirfact->getDireccion()}",70,5,12,0);
$pdf->imprimirTexto("{$dirEnvio->getDireccion()}",60,5,12,1);

$pdf->imprimirTexto("NIF: {$cliente->getDni()}",60,5,12,0);
$pdf->imprimirTexto("{$dirfact->getCiudad()}, {$dirfact->getCp()}",70,5,12,0);
$pdf->imprimirTexto("{$dirEnvio->getCiudad()}, {$dirEnvio->getCp()}",70,5,12,1);

$pdf->imprimirTexto("Email: {$cliente->getEmail()}",60,5,12,1);
$pdf->imprimirTexto("Tel.: {$cliente->getTelefono()}",60,5,12,1);

$titulo=array('Nombre','Cant.','Precio Und.','Precio');
$pdf->AliasNbPages();
$pdf->SetY(100);
$pdf->listarProductos($titulo, $listaProductos);

$pdf->Output();
?>