<?php
require_once '../core/Consult.php';
$codigo=($_GET['Cod']);
$responsable=($_GET['Res']);
$visto=($_GET['Vis']);

//Consulta para generar los datos del informe de hardware rechazado
$query=forced::ejecutar_consulta_simple("SELECT *,T1.mantenimientocodigo FROM mantenimiento as T1, diagnostico as T2, responsable_diagnostico as T3, informacion_ingreso as T5, estado_mantenimiento as T6, hardware as T7, estado_hardware as T8, hardware_ingreso as T9, tipo_hardware as T10, marca_hardware as T11, modelo_hardware as T12, color_hardware as T13, informe_ingreso_hardware as T14, estado_info_hardware as T15, estado_asignacion_hardware as T16, empleados as T17, cargo as T18, departemento as T19, empresa as T20, estado_mantenimiento as T21, tipo_mantenimiento as T22, informacion_entrega as T23, reporte as T24 WHERE T1.mantenimientocodigo='$codigo' AND T1.diagnosticocodigo=T2.diagnosticocodigo AND T2.respdiagcodigo=T3.respdiagcodigo AND T5.ingresocodigo=T2.ingresocodigo AND T1.estadomantenimientocodigo=T6.estadomantenimientocodigo AND T1.hardwareqr=T7.hardwareqr AND T7.estadohardwarecodigo=T8.estadohardwarecodigo AND T7.hiserie=T9.hiserie AND T9.tipohardwarecodigo=T10.tipohardwarecodigo AND T9.marcahardwarecodigo=T11.marcahardwarecodigo AND T9.modelohardwarecodigo=T12.modelohardwarecodigo AND T9.colorhardwarecodigo=T13.colorhardwarecodigo AND T9.icodigo=T14.icodigo AND T9.estadoinfoharcodigo=T15.estadoinfoharcodigo AND T9.estadoasigharcodigo=T16.estadoasigharcodigo AND T7.empleadocodigo=T17.empleadocodigo AND T17.cargocodigo=T18.cargocodigo AND T18.departamentocodigo=T19.departamentocodigo AND T19.empresacodigo=T20.empresacodigo AND T1.estadomantenimientocodigo=T21.estadomantenimientocodigo AND T1.tipomantecodigo=T22.tipomantecodigo AND T1.reportecodigo=T24.reportecodigo AND T23.entregacodigo=T24.entregacodigo");

$data=$query->fetch();

$empleado=trim($data['empleadonombres'])." ".trim($data['empleadoapellidos']);
$departamento=trim($data['departamentonombre']);
$cargo=trim($data['cargonombre']);

$tipo=trim($data['tipohardwarenombre']);
$color=trim($data['colorhardwarenombre']);
$marca=trim($data['marcahardwarenombre']);
$modelo=trim($data['modelohardwarenombre']);
$serie=trim($data['serireexterno']);
$inventario=trim($data['hiserie']);


$reporte=trim($data['reporteservicior']);
$descripcion=trim($data['reporteservicior']);


$horareg=trim($data['ingresohora']);
$fechareg=trim($data['ingresofecha']);

$horaent=trim($data['entregahora']);
$fechaent=trim($data['entregafecha']);
$si=trim($data['reportehm']);
$mantenimiento=trim($data['tipomantenombre']);

//$responsable=trim($_POST['responsable']);
//$visto=trim($_POST['visto']);


require('../fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de p??gina
public function Header()
{
    // Logo
    //$this->Image('logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',12);
    // Movernos a la derecha
    $this->Image('logo.jpg', 190, 5, 23,23, 'jpg');
    // T??tulo
    $this->SetFont('Arial','B',9);
    $this->SetY(10);
    $this->Cell(50,10,'MUNICIPALIDAD DE LATACUNGA',0,0,'C');
    $this->SetX(5);

    $this->SetY(15);
    $this->Cell(50,10,'JEFATURA DE INFORMATICA',0,0,'C');
    $this->SetX(5);
    // Salto de l??nea
    $this->Ln(5);

}

// Pie de p??gina
public function Footer()
{
    // Posici??n: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // N??mero de p??gina
    $this->Cell(0,10,'Page '.$this->PageNo().'',0,0,'C');
}
}
$pdf = new PDF();
$pdf->AddPage('portrait', 'letter');
$pdf->SetFont('Arial','B',12);
$pdf->SetY(26);
$pdf->Cell(0,5,'INFORME TECNICO DE ENTREGA',0,5,'C');
$pdf->SetX(9);
//datos de usuario
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,'Datos de Usuario',0,1,'');
$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Nombre:',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(143,5,''.utf8_decode("".$empleado."").'',1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Departamento:',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(143,5,''.utf8_decode("".$departamento."").'',1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Cargo: ',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(143,5,''.utf8_decode("".$cargo."").'',1,1,'C');
//datos del Equipo



//datos de usuario
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,'Datos del equipo',0,1,'');


$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Tipo',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(47,5,''.utf8_decode("".$tipo."").'',1,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Color',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(46,5,''.utf8_decode("".$color."").'',1,1,'C');


$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Marca:',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(143,5,''.utf8_decode("".$marca."").'',1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Modelo: ',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(143,5,''.utf8_decode("".$modelo."").'',1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'# Serie:',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(143,5,''.utf8_decode($serie).'',1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Cod. Inventario: ',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(143,5,''.utf8_decode($inventario).'',1,1,'C');
//datos del Equipo


//REPORTE USUARIO
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,'Reporte de Usuario',0,1,'');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(190,4,''.utf8_decode("".$reporte."").'',0,'J',0);
//Descripci??n de Servicio Realizado
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,''.utf8_decode("Descripci??n del Servicio Realizado").'',0,1,'');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(190,5,''.utf8_decode("".$descripcion."").'',0,'J',0);
//FECHA-HORA
//FECHA INGRESO
$pdf->cell(40,5,'',0,6,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Fecha Ingreso',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(49,5,''.utf8_decode("".$fechareg."").'',1,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Hora',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode("".$horareg."").'',1,1,'C');
//FECHA ENTREGA 
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Fecha Entrega',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(49,5,''.utf8_decode("".$fechaent."").'',1,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Hora',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode("".$horaent."").'',1,1,'C');
//Se entrega Equipo por mostrado
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Se Entrega Equipo Por Mostar',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(49,5,''.utf8_decode($si).'',1,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Tipo de mantenimiento',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode("".$mantenimiento."").'',1,1,'C');

// firmas--------------------------------
//FECHA INGRESO
$pdf->cell(40,5,'',0,6,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(40,10,'FIRMAS',0,1,'L');
$pdf->cell(40,10,'',0,6,'C');
$pdf->cell(60,10,'________________________',0,0,'C');
$pdf->cell(60,10,'________________________',0,0,'C');
$pdf->cell(60,10,'________________________',0,1,'C');
$pdf->cell(60,10,'Ing. Fabian Vega',0,0,'C');
$pdf->cell(60,10,'RECIBI CONFORME',0,0,'C');
$pdf->cell(60,10,''.utf8_decode("".$responsable."").'',0,5,'C');
$pdf->cell(60,10,'Responsable',0,0,'C'); 
$pdf->Output();
?>
