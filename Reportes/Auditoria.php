
<?php
require_once '../core/consult.php';
$codigo=forced::decryption($_GET['Cod']);

//Consulta para generar los datos del informe de hardware rechazado
$query=forced::ejecutar_consulta_simple("SELECT *,T1.ICODIGO FROM informe_ingreso_hardware as T1, hardware_ingreso as T3, tipo_hardware as T5, marca_hardware as T6, modelo_hardware as T7, color_hardware as T8, estado_info_hardware as T9 WHERE T3.HISERIE='$codigo' AND T3.ICODIGO=T1.ICODIGO AND T3.TIPOHARDWARECODIGO=T5.TIPOHARDWARECODIGO AND T3.MARCAHARDWARECODIGO=T6.MARCAHARDWARECODIGO AND T3.MODELOHARDWARECODIGO=T7.MODELOHARDWARECODIGO AND T3.COLORHARDWARECODIGO=T8.COLORHARDWARECODIGO AND T3.ESTADOINFOHARCODIGO=T9.ESTADOINFOHARCODIGO");

$data=$query->fetch();

$a=$data['ICODIGO'];
$tema=$data['ITEMA'];
$fecha=$data['HIFECHA'];
$servicio=$data['ITIPOSERVICIO'];
$trabajo=$data['ILUGARTRABAJO'];
$antecedentes=$data['IANTECEDENTES'];
$objetivos=$data['IOBJETIVOS'];
$analisis=$data['IANALISIS'];
$conclusiones=$data['ICONCLUSIONES'];
$recomendaciones=$data['IRECOMENDACIONES'];



$titulo=$data['HITITULO'];
$tipo=$data['TIPOHARDWARENOMBRE'];
$marca=$data['MARCAHARDWARENOMBRE'];
$modelo=$data['MODELOHARDWARENOMBRE'];
$serie=$data['HISERIE'];
$inventario=$data['SERIREEXTERNO'];
$color=$data['COLORHARDWARENOMBRE'];
$caracterisitca=$data['HICARACTERISTICAS'];
$cables=$data['HICABLES'];
$observaciones=$data['HIOBSERVACIONES'];


$res=$data['IRESPOELABORADO'];
$consultaNom=forced::ejecutar_consulta_simple("SELECT * FROM empleados WHERE EMPLEADOCODIGO='$res'");
$InfoNom=$consultaNom->fetch();
$responsable=$InfoNom['EMPLEADOAPELLIDOS']." ".$InfoNom['EMPLEADONOMBRES'];


$vis=$data['IRESPOVISTO'];
$consultaNom=forced::ejecutar_consulta_simple("SELECT * FROM empleados WHERE EMPLEADOCODIGO='$vis'");
$InfoNom=$consultaNom->fetch();
$visto=$InfoNom['EMPLEADOAPELLIDOS']." ".$InfoNom['EMPLEADONOMBRES'];





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
    $this->Image('logo1.png', 70, 10, 70,15, 'png');
    $this->SetY(180);
    // Título
    $this->SetFont('Arial','B',9);
    $this->SetY(5);
    $this->Cell(50,10,'MUNICIPALIDAD DE LATACUNGA',0,0,'C');
    $this->SetX(5);

    $this->SetY(10);
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
$pdf->Cell(0,5,''.utf8_decode("AUDITORIA DE HARDWARE").'',0,5,'C');
$pdf->SetX(9);


//
$pdf->cell(40,5,'',0,6,'C');

//

//FECHA
$pdf->SetX(9);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(190,4,'LATACUNGA, '.utf8_decode($fecha).'.',0,'J',0);
//DATOS GENERALES
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,'1. DATOS GENERALES',0,1,'');
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,''.utf8_decode("*   TIPO DE SERVICIO").'',0,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(40,5,''.utf8_decode($servicio).'',0,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,''.utf8_decode("*   LUGAR DE TRABAJO").'',0,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(66,5,''.utf8_decode($trabajo).'',0,1,'C');
//ANTECEDENTES
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,'2. ANTECEDENTES',0,1,'');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(190,4,''.utf8_decode($antecedentes).'',0,'J',0);


/*$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,'Datos del equipo',0,1,'');*/

$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Tipo',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(49,5,''.utf8_decode("".$tipo."").'',1,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Marca',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode("".$marca."").'',1,1,'C');
//FECHA ENTREGA 
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Modelo',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(49,5,''.utf8_decode("".$modelo."").'',1,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,''.utf8_decode("Color").'',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode("".$color."").'',1,1,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,''.utf8_decode("# Serie").'',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(49,5,''.utf8_decode("".$serie."").'',1,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,''.utf8_decode("Cod. Inventario").'',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode("".$inventario."").'',1,1,'C');


$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Cables:',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(144,5,''.utf8_decode("".$cables."").'',1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Observaciones: ',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(144,5,''.utf8_decode("".$observaciones."").'',1,1,'C');


$pdf->SetY(180);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(38,18,'CARACTERISTICAS',0,1,'');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(190,4,''.utf8_decode($caracterisitca).'',0,'J',0);

//CONCLUSIONES
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,'5. CONCLUSIONES',0,1,'');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(190,4,''.utf8_decode($conclusiones).'',0,'J',0);
//CONCLUSIONES
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,'6. RECOMENDACIONES',0,1,'');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(190,4,''.utf8_decode($recomendaciones).'',0,'J',0);


// firmas--------------------------------
//FECHA INGRESO
$pdf->cell(40,5,'',0,6,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(40,10,'FIRMAS',0,1,'L');
$pdf->cell(40,10,'',0,6,'C');
$pdf->cell(110,10,'________________________',0,0,'C');
$pdf->cell(60,10,'________________________',0,1,'C');

$pdf->cell(110,10,''.utf8_decode($responsable).'',0,0,'C');
$pdf->cell(60,10,''.utf8_decode($visto).'',0,1,'C');

$pdf->cell(110,10,'RESPONSABLE',0,0,'C');
$pdf->cell(60,10,'VISTO BUENO',0,1,'C');




$pdf->Output();
?>
