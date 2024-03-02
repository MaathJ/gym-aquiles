<?php
include_once("auth.php");
include_once("inc/estructura/parte_superior.php");
include_once("matricula/U_estadoMatricula.php");
include('config/dbconnect.php');

$fechaHoy = new DateTime();
$mesactual = $fechaHoy->format('m');
$añoactual = $fechaHoy->format('Y');

// INGRESO S/. DE HOY (MATRICULA REALIZADAS)
$Ingreso_Matricul = "SELECT sum(men.precio_me) as total FROM matricula ma inner join membresia men on 
  ma.id_me = men.id_me WHERE DATE(ma.fecharegistro_ma) = CURDATE();";
$IMatricula = mysqli_query($cn, $Ingreso_Matricul);
$rMatricula = mysqli_fetch_assoc($IMatricula);


// INGRESO S/. DE HOY ( ASISTENCIA POR CLASE)
$Ingreso_APago = "SELECT sum(tp.precio_tiru) as total FROM asistencia_pago ap inner join tipo_rutina tp on 
  ap.id_tiru = tp.id_tiru WHERE DATE(ap.fech_asip) = CURDATE();";
$IAPago = mysqli_query($cn, $Ingreso_APago);
$rAPago = mysqli_fetch_assoc($IAPago);


$suma = $rMatricula['total'] + $rAPago['total'];

// LAS 10 MATRICULAS  QUE TIENEN POCOS DIAS PARA CULMINAR (5)


//INICIO PARA CONSULTA de cantidad de matriculados

$sqlMatric = "SELECT COUNT(id_ma) as countmatricula FROM matricula WHERE estado_ma='ACTIVO'";
$fMatric = mysqli_query($cn, $sqlMatric);
$rMatric = mysqli_fetch_assoc($fMatric);


//INICIO CONSULTA PARA GRAFICO CIRCULAR 
$sqlC = "SELECT 
    ROUND(COUNT(CASE WHEN cli.genero_cli = 'MASCULINO' THEN 1 END) * 100 / COUNT(*)) AS porcentaje_hombres_con_asistencia
    FROM 
    cliente as cli
    INNER JOIN Matricula AS ma ON cli.id_cli = ma.id_cli
    INNER JOIN asistencia as asi ON ma.id_ma = asi.id_ma
    WHERE MONTH(asi.fecha_as) = $mesactual and YEAR(asi.fecha_as)=$añoactual";

$fC = mysqli_query($cn, $sqlC);
$rCir = mysqli_fetch_assoc($fC);
$HOMBRE = (int)$rCir['porcentaje_hombres_con_asistencia'];

// Conteo de mujeres con asistencia
$sqlM = "SELECT 
    ROUND(COUNT(CASE WHEN cli.genero_cli = 'FEMENINO' THEN 1 END) * 100 / COUNT(*)) AS porcentaje_mujeres_con_asistencia
    FROM 
    cliente as cli
    INNER JOIN Matricula AS ma ON cli.id_cli = ma.id_cli
    INNER JOIN asistencia as asi ON ma.id_ma = asi.id_ma
    WHERE MONTH(asi.fecha_as) = $mesactual and YEAR(asi.fecha_as)=$añoactual";

$fM = mysqli_query($cn, $sqlM);
$rCirM = mysqli_fetch_assoc($fM);
$MUJER = (int)$rCirM['porcentaje_mujeres_con_asistencia'];
//FIN CONSULTA PARA GRAFICO CIRCULAR 

// INICIO  CONSULTA PARA GANANCIA
$sql_g = "SELECT SUM(ganancia) as total
FROM (
	SELECT SUM(me.precio_me) AS ganancia
	FROM matricula ma INNER JOIN membresia me ON ma.id_me = me.id_me
	WHERE
	MONTH(ma.fecharegistro_ma) = MONTH(NOW()) AND
	YEAR(ma.fecharegistro_ma) = YEAR(NOW())

	UNION ALL

	SELECT SUM(tr.precio_tiru) AS ganancia
	FROM asistencia_pago ap INNER JOIN tipo_rutina tr ON ap.id_tiru = tr.id_tiru
	WHERE
	MONTH(ap.fech_asip) = MONTH(NOW()) AND
	YEAR(ap.fech_asip) = YEAR(NOW())
) as ganancia_resultado";


$f_g = mysqli_query($cn, $sql_g);
$r_g = mysqli_fetch_assoc($f_g);

// INICIO  CONSULTA PARA TOP 20 ASISTENTES
$sql_a20 = "SELECT c.dni_cli,
  CONCAT(c.apellido_cli, ', ', c.nombre_cli) AS persona,
  me.nombre_me AS membresia
  ,COUNT(id_as) AS asistencia
  FROM asistencia a INNER JOIN matricula ma ON a.id_ma = ma.id_ma
  INNER JOIN cliente c ON ma.id_cli = c.id_cli
  INNER JOIN membresia me ON ma.id_me = me.id_me
  WHERE
  MONTH(a.fecha_as) = MONTH(NOW()) AND
  YEAR(a.fecha_as) = YEAR(NOW())
  GROUP BY c.dni_cli,persona, membresia
  ORDER BY COUNT(id_as) desc
LIMIT 20";

$f_a20 = mysqli_query($cn, $sql_a20);


// INICIO  CONSULTA ASISTIDOS HOY MATRICULADOS.
$sql_mat = "SELECT COUNT(id_as) AS asistencia
FROM asistencia 
WHERE
DATE(fecha_as) = DATE(NOW())";

$f_mat = mysqli_query($cn, $sql_mat);
$r_mat = mysqli_fetch_assoc($f_mat);

// // INICIO  CONSULTA ASISTIDOS HOY CLASE.
$sql_cla = "SELECT COUNT(id_asip) AS asistencia
FROM asistencia_pago
WHERE
DATE(fech_asip) = DATE(NOW())";

$f_cla = mysqli_query($cn, $sql_cla);
$r_cla = mysqli_fetch_assoc($f_cla);

//CONSULTA PARA DIFERENTES TIPO DE PAGO
$sql_dtp="SELECT tpago.tipopago, SUM(tpago.total) AS total
  FROM (SELECT tp.desc_tp as tipopago, sum(tr.precio_tiru) as total
  FROM tipo_pago tp
  INNER JOIN asistencia_pago ap on ap.id_tp = tp.id_tp
  inner join tipo_rutina tr on ap.id_tiru = tr.id_tiru
  WHERE DATE(ap.fech_asip) = CURDATE()
  GROUP BY tp.desc_tp

  UNION ALL

  SELECT tp.desc_tp as tipopago, sum(men.precio_me) as total 
  FROM tipo_pago tp
  inner join matricula ma on ma.id_tp = tp.id_tp
  inner join membresia men on ma.id_me = men.id_me 
  WHERE DATE(ma.fecharegistro_ma) = CURDATE()
  GROUP BY tp.desc_tp) as tpago
  GROUP BY tpago.tipopago";

$f_dtp = mysqli_query($cn, $sql_dtp);

//------------------------------------------------------
date_default_timezone_set('America/Lima');
 $fechaHoy = new DateTime();
 $mesactual =$fechaHoy->format('m') ;
 $añoactual =$fechaHoy->format('Y') ;

 $sql = "SELECT dias, SUM(precios) as total_precios
 FROM (
     SELECT date(ma.fecharegistro_ma) as dias, SUM(me.precio_me) as precios
     FROM matricula as ma
     INNER JOIN membresia as me ON ma.id_me = me.id_me
     WHERE MONTH(ma.fecharegistro_ma) = $mesactual and YEAR(ma.fecharegistro_ma)=$añoactual
     GROUP BY dias
     
     UNION ALL
     
     SELECT date(ap.fech_asip) as dias, SUM(tr.precio_tiru) as precios
     FROM asistencia_pago as ap
     INNER JOIN tipo_rutina tr ON ap.id_tiru = tr.id_tiru
     WHERE MONTH(ap.fech_asip) = $mesactual and YEAR(ap.fech_asip)=$añoactual
     GROUP BY dias
 ) as union_resultados
 GROUP BY dias";

$resultado = mysqli_query($cn, $sql);

// Inicializar arrays para almacenar los resultados
$dias = array();
$precios = array();

// Recorrer los resultados y almacenar en los arrays
while ($fila = mysqli_fetch_assoc($resultado)) {
$dias[] = date('d-m-Y', strtotime($fila['dias']));
$precios[] = $fila['total_precios'];
}
?>
<link rel="stylesheet" src="style.css" href="assets/css/dashboard/dashboard.css">
<link rel="stylesheet" src="style.css" href="assets/css/bootstrap/bootstrap.css">
<div class="app-body-main-content">
  <div>
    <p>Pages<span> / Dashboard</span></p>
    <h3>Dashboard</h3>
  </div>
  <div class="main-content">
    <div class="main-content-top">
      <div class="main-content-left">
        <div class="content-left-earnings">
          <!-- INGRESO MENSUAL -->
          <?php 
                    $cod = $_SESSION["usuario"];
                    $sql = "SELECT * FROM usuario as us INNER JOIN rol as ro ON us.id_ro = ro.id_ro WHERE us.id_us = $cod AND ro.nombre_ro='ADMINISTRADOR'";
                    // Ejecutar la consulta y obtener el resultado...
                    
                    $resultado = mysqli_query($cn,$sql);
                    // Verificar si el usuario tiene el rol de ADMINISTRADOR
                    if ($resultado && mysqli_num_rows($resultado) > 0) {
                    ?>
          <div class="card-earnings-sol">
            <div class="card-earnings-title">
              <span><i class="fa-solid fa-money-bill"></i></span>
              <p>Ingreso mes de:
                <?php
                  $mes = date("n");
                  switch ($mes) {
                    case 1:echo "Enero"; break;
                    case 2:echo "Febrero"; break;
                    case 3:echo "Marzo";break;
                    case 4:echo "Abril";break;
                    case 5:echo "Mayo";break;
                    case 6:echo "Junio";break;
                    case 7:echo "Julio";break;
                    case 8:echo "Agosto";break;
                    case 9:echo "Setiembre";break;
                    case 10:echo "Octubre";break;
                    case 11:echo "Noviembre";break;
                    case 12:echo "Diciembre";break;
                  }
                ?>
              </p>
            </div>
            <h2 class="card-earnings-text mb-1">
              <?php echo "S/. " . $r_g['total']; ?>
            </h2>
          </div>
          <?php } ?>

          <div class="card-earnings-sol">
            <div class="card-earnings-title">
              <span><i class="fa-solid fa-money-bill"></i></span>
              <p>Caja Soles Matriculados Hoy</p>
            </div>
            <h2 class="card-earnings-text">
              <?php echo " S/" . $rMatricula['total'] ?>
            </h2>
          </div>
          <div class="card-earnings-sol">
            <div class="card-earnings-title">
              <span><i class="fa-solid fa-money-bill"></i></span>
              <p>Caja Soles Por Clase Hoy</p>
            </div>
            <h2 class="card-earnings-text">
              <?php echo " S/" . $rAPago['total'] ?>
            </h2>
          </div>
          <div class="card-earnings-sol">
            <div class="card-earnings-title">
              <span><i class="fa-solid fa-money-bill"></i></span>
              <p>Caja Soles Total Hoy</p>
            </div>
            <h2 class="card-earnings-text">
              <?php echo  " S/" . $rMatricula['total'] + $rAPago['total'] ?>
            </h2>
          </div>
        </div>
        <div class="content-left-earnings">
          <!-- INGRESO POR TIPO DE PAGO -->
          <?php 
          while($r_dtp = mysqli_fetch_assoc($f_dtp)){
          ?>
            <div class="card-earnings-sol">
              <div class="card-earnings-title">
                <span><i class="fas fa-money-bills"></i></span>
                <p>
                  <?php echo $r_dtp['tipopago']; ?>
                </p>
              </div>
              <h2 class="card-earnings-text">
                S/ <?php echo $r_dtp['total']; ?>
              </h2>
            </div>
          <?php } ?>
        </div>
        <div class="content-left-earnings">
          <!-- INGRESO MENSUAL -->
          <div class="card-earnings-ma">
            <div class="card-earnings-title">
              <span><i class="fa-solid fa-newspaper"></i></span>
              <p>
                Matriculados
              </p>
            </div>
            <h2 class="card-earnings-text">
              <?php echo $rMatric['countmatricula'] ?>
            </h2>
          </div>

          <div class="card-earnings-ma">
            <div class="card-earnings-title">
              <span><i class="fa-solid  fa-door-open"></i></span>
              <p>Asistencia Hoy Matriculados</p>
            </div>
            <h2 class="card-earnings-text">
              <?php echo $r_mat['asistencia']; ?>
            </h2>
          </div>

          <div class="card-earnings-ma">
            <div class="card-earnings-title">
              <span><i class="fa-solid  fa-door-open"></i></span>
              <p>Asistencia Hoy Por Clase</p>
            </div>
            <h2 class="card-earnings-text">
              <?php echo $r_cla['asistencia']; ?>
            </h2>
          </div>

          <div class="card-earnings-ma">
            <div class="card-earnings-title">
              <span><i class="fa-solid  fa-door-open"></i></span>
              <p>Asistencia Total Hoy</p>
            </div>
            <h2 class="card-earnings-text">
              <?php echo ($r_mat['asistencia'] + $r_cla['asistencia']); ?>
            </h2>
          </div>
        </div>   

        <div class="content-left-tables">
          <!-- LOS 20 CLIENTES QUE MÁS ASISTEN -->
          <div class="table">
            <h3>Los Matriculados que más asisten</h3>
            <div class="content-table-one">
              <?php
                        while ($r_a20 = mysqli_fetch_assoc($f_a20)) {
                        ?>
              <div class="table-card">
                <div class="table-card-info">
                  <div class="card-info">
                    <img src="assets/images/cliente/<?php echo $r_a20['dni_cli'] ?>.jpg" width="30px" height="30px">
                  </div>
                  <div>
                    <?php echo $r_a20['persona'] . " (" . $r_a20['membresia'] . ")"; ?>
                  </div>
                </div>
                <div class="table-card-days">
                  <?php echo $r_a20['asistencia']; ?> asistencia
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
          <!-- MATRICULADOS A VENCER -->
          <div class="table">
            <h3>Matriculas a Vencer</h3>
            <div class="content-table-one">
              <?php
                        $Matriculas_acabar = "SELECT 
                    cl.nombre_cli, 
                    cl.apellido_cli, 
                    cl.dni_cli, 
                    DATEDIFF(DATE(mt.fechafin_ma), DATE(NOW())+1) AS dias_restantes
                    FROM 
                        cliente cl
                    INNER JOIN 
                        matricula mt ON cl.id_cli = mt.id_cli
                    WHERE 
                        DATEDIFF(DATE(mt.fechafin_ma), DATE(NOW())) BETWEEN 0 AND 5
                        AND mt.estado_ma='ACTIVO'
                    ORDER BY 
                        DATEDIFF(DATE(mt.fechafin_ma), DATE(mt.fechainicio_ma)) DESC
                    LIMIT 10";

                        $fMFaltante = mysqli_query($cn, $Matriculas_acabar);

                        while ($rMFaltante = mysqli_fetch_assoc($fMFaltante)) {
                        ?>
              <div class="table-card">
                <div class="table-card-info">
                  <div class="card-info">
                    <img src="assets/images/cliente/<?php echo $rMFaltante['dni_cli'] ?>.jpg" alt="">
                  </div>
                  <div>
                    <?php echo $rMFaltante['nombre_cli']  . " " . $rMFaltante['apellido_cli'] ?>
                  </div>
                </div>
                <div class="table-card-days">
                  <?php echo "Quedan " . $rMFaltante['dias_restantes'] . " Dias" ?>
                </div>
              </div>
              <?php
                        }
                        ?>
            </div>
          </div>
        </div>
      </div>
      <div class="main-content-right">
        <div class="stats-total-earnings">
          <h3>Ingreso Hombres y Mujeres (%)</h3>
          <div>
            <canvas id="pie-hm"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="main-content-bottom">
    <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a  class="nav-link active" id="ingreso-dia-mes" >Ingreso de los Días del Mes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ingreso-mes-año">Ingreso Meses del año</a>
                </li>
            </ul>
      <div class="ingresos-mes-dia">
        <canvas id="chart-barra-ingreso-dia-mes"></canvas>
        <canvas id="chart-barra-ingreso-mes-año" style="display: none;"></canvas>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script src="assets/js/chartjs/pie-ingresos.js"></script>
<script src="assets/js/tabs-asistencia/tabs-barras.js"></script>
<script>
const ingresoDiaMes= document.getElementById('chart-barra-ingreso-dia-mes');
new Chart(ingresoDiaMes, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($dias); ?>,
        datasets: [{
            label: 'Ingreso diario',
            data: <?php echo json_encode($precios); ?>,
            borderWidth: 1,
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
                'rgba(153, 102, 255)',
                'rgba(75, 192, 192)',
                'rgba(201, 203, 207)',
            ],
            borderColor: '#36A2EB',
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'Ingresos de los Días del Mes',
                font: {
                    size: 16
                }
            }
        }
    }
});

const ingresoMesAño = document.getElementById('chart-barra-ingreso-mes-año');
new Chart(ingresoMesAño, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($dias); ?>,
        datasets: [{
            label: 'Ingreso Mensual',
            data: <?php echo json_encode($precios); ?>,
            borderWidth: 1,
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
                'rgba(153, 102, 255)',
                'rgba(75, 192, 192)',
                'rgba(201, 203, 207)',
            ],
            borderColor: '#36A2EB',
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'Ingresos de los Meses del Año',
                font: {
                    size: 16
                }
            }
        }
    }
});

</script>
<?php
include_once("inc/estructura/parte_inferior.php")
?>
