<?php
require_once '../core/consult.php';
$codigo=($_GET['Cod']);
$responsable=($_GET['Res']);

//Consulta para generar los datos del informe de hardware rechazado
$query=forced::ejecutar_consulta_simple("SELECT *,T1.mantenimientocodigo FROM mantenimiento as T1, diagnostico as T2, responsable_diagnostico as T3, informacion_ingreso as T5, estado_mantenimiento as T6, hardware as T7, estado_hardware as T8, hardware_ingreso as T9, tipo_hardware as T10, marca_hardware as T11, modelo_hardware as T12, color_hardware as T13, informe_ingreso_hardware as T14, estado_info_hardware as T15, estado_asignacion_hardware as T16, empleados as T17, cargo as T18, departemento as T19, empresa as T20  WHERE T1.mantenimientocodigo='$codigo' AND T1.diagnosticocodigo=T2.diagnosticocodigo AND T2.respdiagcodigo=T3.respdiagcodigo AND T5.ingresocodigo=T2.ingresocodigo AND T1.estadomantenimientocodigo=T6.estadomantenimientocodigo AND T1.hardwareqr=T7.hardwareqr AND T7.estadohardwarecodigo=T8.estadohardwarecodigo AND T7.hiserie=T9.hiserie AND T9.tipohardwarecodigo=T10.tipohardwarecodigo AND T9.marcahardwarecodigo=T11.marcahardwarecodigo AND T9.modelohardwarecodigo=T12.modelohardwarecodigo AND T9.colorhardwarecodigo=T13.colorhardwarecodigo AND T9.icodigo=T14.icodigo AND T9.estadoinfoharcodigo=T15.estadoinfoharcodigo AND T9.estadoasigharcodigo=T16.estadoasigharcodigo AND T7.empleadocodigo=T17.empleadocodigo AND T17.cargocodigo=T18.cargocodigo AND T18.departamentocodigo=T19.departamentocodigo AND T19.empresacodigo=T20.empresacodigo");

$data=$query->fetch();

$empleado=trim($data['empleadonombres'])." ".trim($data['empleadoapellidos']);
$departamento=trim($data['departamentonombre']);
$cargo=trim($data['cargonombre']);
$hora=trim($data['ingresohora']);
$telefono=trim($data['empleadocelular']);
$fecha=trim($data['ingresofecha']);


$tipo=trim($data['tipohardwarenombre']);
$marca=trim($data['marcahardwarenombre']);
$modelo=trim($data['modelohardwarenombre']);
$color=trim($data['colorhardwarenombre']);
$serie=trim($data['serireexterno']);
$inventario=trim($data['hiserie']);


$reporte=trim($data['diagnosticoreporteusuario']);
$informe=trim($data['diagnosticoinformetecnico']);



require('../fpdf/fpdf.php');
class PDF extends FPDF
{
// Cabecera de página
public function Header()
{
    // Logo
    //$this->Image('logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',12);
    // Movernos a la derecha
    $this->Image('logo.jpg', 190, 5, 23,23, 'jpg');
    // Título
    $this->SetFont('Arial','B',9);
    $this->SetY(10);
    $this->Cell(50,10,'MUNICIPALIDAD DE LATACUNGA',0,0,'C');
    $this->SetX(5);

    $this->SetY(15);
    $this->Cell(50,10,'JEFATURA DE INFORMATICA',0,0,'C');
    $this->SetX(5);
    // Salto de línea
    $this->Ln(5);

}

// Pie de página
public function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'',0,0,'C');
}
}
$pdf = new PDF();
$pdf->AddPage('portrait', 'letter');
$pdf->SetFont('Arial','B',12);
$pdf->SetY(26);
$pdf->Cell(0,5,'HOJA DE DIAGNOSTICO DEL EQUIPO',0,5,'C');
$pdf->SetX(9);


//
$pdf->cell(40,5,'',0,6,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(29,10,'Datos del usuario',0,0,'C');
$pdf->Cell(185,10,'Datos del ingreso',0,1,'C');
$pdf->cell(40,5,'',0,6,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(36,5,'Usuario',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(71,5,''.utf8_decode($empleado).'',1,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(36,5,'Hora',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode($hora).'',1,1,'C');
//FECHA ENTREGA 
$pdf->SetFont('Arial','B',8);
$pdf->cell(36,5,'Departamento',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(71,5,''.utf8_decode($departamento).'',1,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(36,5,''.utf8_decode("Teléfono").'',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode($telefono).'',1,1,'C');
//Se entrega Equipo por mostrado
$pdf->SetFont('Arial','B',8);
$pdf->cell(36,5,'Cargo',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(71,5,''.utf8_decode($cargo).'',1,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(36,5,'Fecha',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode($fecha).'',1,1,'C');
//







//datos de usuario
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,'Datos del equipo',0,1,'');


$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Tipo',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(49,5,''.utf8_decode($tipo).'',1,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Marca',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode($marca).'',1,1,'C');
//FECHA ENTREGA 
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Modelo',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(49,5,''.utf8_decode($modelo).'',1,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,''.utf8_decode("Color").'',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode($color).'',1,1,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'# Serie',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(49,5,''.utf8_decode($serie).'',1,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Cod. Inventario',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode($inventario).'',1,1,'C');
//Se entrega Equipo por mostrado
//Se entrega Equipo por mostrado
//


//REPORTE USUARIO
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,'Reporte de Usuario',0,1,'');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(190,4,''.utf8_decode($reporte).'',0,'J',0);
//Descripción de Servicio Realizado
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,''.utf8_decode("Informe Técnico").'',0,1,'');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(190,5,''.utf8_decode($informe).'',0,'J',0);
//FECHA-HORA


// firmas--------------------------------
//FECHA INGRESO
$pdf->cell(40,5,'',0,6,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(40,10,'FIRMA',0,1,'L');
$pdf->cell(40,10,'',0,6,'C');

$pdf->cell(190,10,'________________________________',0,1,'C');

$pdf->cell(190,10,''.utf8_decode("".$responsable."").'',0,5,'C');
$pdf->cell(190,10,''.utf8_decode("Técnico Responsable").'',0,0,'C');
$pdf->Output();
?>
