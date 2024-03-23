<?php
include_once('config/dbconnect.php');
include_once("fpdf/fpdf.php");

//CONSULTA PARA LOS DATOS DEL GYM
$sql_gym="SELECT * FROM configurador_historial WHERE estado_conf = 'ACTIVO'";
$f_gym = mysqli_query($cn, $sql_gym);
$r_gym = mysqli_fetch_assoc($f_gym);

// Falta crear esa tabla, los datos seran generales mientras
$nombre=$r_gym['txt_negocio'];
$ruc=$r_gym['ruc_negocio'];
$lugar=$r_gym['direccion_negocio'];
$contacto=$r_gym['telefono_negocio'];
$ruta=$r_gym['foto_conf'];

//CONSULTA DE LOS DATOS DEL TICKET
$id=$_GET['cod'];
$dest=$_GET['dest'];

//La consulta varia dependiendo el origen
switch($dest){
    case "mat": $sql="select * 
                from matricula ma 
                inner join cliente cl on ma.id_cli = cl.id_cli
                inner join membresia me on ma.id_me = me.id_me
                inner join tipo_pago tp on ma.id_tp = tp.id_tp
                where id_ma=$id";
                break;
    case "a_mat": $sql="select * 
                    from asistencia asi
                    inner join matricula ma  on asi.id_ma = ma.id_ma
                    inner join cliente cl on ma.id_cli = cl.id_cli
                    inner join membresia me on ma.id_me = me.id_me
                    where id_as=$id";
                    break;
    case "a_dia": $sql="select * 
                    from asistencia_pago asi
                    inner join tipo_rutina tr on asi.id_tiru = tr.id_tiru
                    inner join tipo_pago tp on asi.id_tp = tp.id_tp
                    where id_asip=$id";
                    break;
}

$f=mysqli_query($cn, $sql);
$r=mysqli_fetch_assoc($f);

//Constantes para usar
switch($dest){
    case "mat": //Titulo
                $tit="TICKET DE VENTA";

                //Datos de fecha
                $fecha1=new DateTime($r['fechainicio_ma'] );
                $fecha2=new DateTime(date("d-m-Y", strtotime($r['fechafin_ma']. "- 1 days")));
                $diff = $fecha1 -> diff($fecha2);

                //Datos principales
                $dni=$r['dni_cli'];
                $name=$r['apellido_cli'].', '.$r['nombre_cli'];
                $tipa=$r['desc_tp'];

                //Detalles
                $det1="DETALLE DE VENTA";
                $det2="";

                //Contenido
                $cont1="MEMBRESIA - " . $r['nombre_me'];
                $cont2="S/. " . $r['precio_me'];

                //Ultima información
                $ui=1;
                $dias= mb_convert_encoding($diff->days .' días', 'ISO-8859-1', 'UTF-8');
                $fini=$fecha1->format('d-m-Y');
                $ffin=$fecha2->format('d-m-Y');
                $total="S/. ".$r['precio_me'];
                break;
    case "a_mat": //Titulo
                $tit="TICKET DE ASISTENCIA";

                //Datos de fecha 
                $tiempo = new Datetime($r['fecha_as']);
                $fecha = $tiempo->format('H:i d-m-Y');

                //Datos principales
                $dni=$r['dni_cli'];
                $name=$r['apellido_cli'].', '.$r['nombre_cli'];
                $tipa="";

                //Detalles
                $det1="MEMBRESIA";
                $det2="HORA / FECHA";

                //Contenido
                $cont1=$r['nombre_me'];
                $cont2=$fecha;

                //Ultima información
                $ui=0;
                $dias="";
                $fini="";
                $ffin="";
                $total="";
                break;
    case "a_dia": //Titulo
                $tit="TICKET DE ASISTENCIA";

                //Datos de fecha 
                $tiempo = new Datetime($r['fech_asip']);
                $fecha = $tiempo->format('H:i d-m-Y');

                //Datos principales
                $dni="";
                $name=$r['nomb_asip'];
                $tipa=$r['desc_tp'];

                //Detalles
                $det1="MEMBRESIA";
                $det2="HORA / FECHA";

                //Contenido
                $cont1=$r['nombre_tiru']." - S/. ".$r['precio_tiru'];
                $cont2=$fecha;

                //Ultima información
                $ui=0;
                $dias="";
                $fini="";
                $ffin="";
                $total="";
                break;
}

//---------------------------------TICKET---------------------------------
$pdf = new FPDF('P', 'mm', array(80,200));
$pdf->addPage();
$pdf->SetMargins(5, 5, 5);

//-----Cabecera
    $pdf->Image($ruta, 10, 6, 24, 0, 'JPEG');

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(25, 6, '',0, 0, 'L');
    $pdf->Cell(10, 6, mb_convert_encoding(strtoupper($nombre), 'ISO-8859-1', 'UTF-8'),0, 1, 'L');
    $pdf->Cell(30, 6, '',0, 0, 'L');
    $pdf->Cell(10, 6, 'RUC: '.$ruc,0, 1, 'L');
    $pdf->Cell(30, 6, '',0, 0, 'L');
    $pdf->Cell(65, 6, mb_convert_encoding(strtoupper($lugar), 'ISO-8859-1', 'UTF-8'),0, 1, 'L');
    $pdf->Cell(30, 6, '',0, 0, 'L');
    $pdf->Cell(25, 6, 'CONTACTO: '.$contacto,0, 1, 'L');

    $pdf->Ln(5);

//-----Titulo
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->MultiCell(70, 5, $tit, 0, 'C');
    $pdf->Ln(4);

//-----Datos principales
    if($dni!=""){
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(22, 5, 'Dni cliente: ',0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(15, 5, $dni,0, 1, 'L');
    }

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(22, 5, 'Nombre cliente: ',0, 0, 'L');
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(50, 5, mb_convert_encoding(strtoupper($name), 'ISO-8859-1', 'UTF-8'), 0, 'L');

    if($tipa!=""){
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(22, 5, 'Tipo de pago: ',0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(15, 5, $r['desc_tp'],0, 1, 'L');
    }

    $pdf->Ln(5);

//-----Detalles
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(25, 5, $det1, 0, 0, 'L');
    $pdf->Cell(45, 5, $det2, 0, 1, 'R');
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(25, 5, '-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-',0, 1, 'L');

        //-----Contenido
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(15, 5, $cont1, 0, 0, 'L');
        $pdf->Cell(55, 5, $cont2,0, 1, 'R');


    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(25, 5, '-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-',0, 1, 'L');

//-----Ultima información
    if($ui==1){
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(20, 5, mb_convert_encoding('Duración: ', 'ISO-8859-1', 'UTF-8'),0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(15, 5, $dias, 0, 1, 'L');
        
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(20, 5, 'Fecha inicio: ',0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(15, 5, $fini, 0, 1, 'L');
        
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(20, 5, 'Fecha fin: ',0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(15, 5, $ffin, 0, 1, 'L');
        
        $pdf->Ln(5);
        
        //-----Precio
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(55, 5, 'Total: ',0, 0, 'R');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(15, 5, $total, 0, 1, 'R');
    }

//-----Mostrar ventana
$pdf->Output();
?>