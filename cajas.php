<?php
include_once('auth.php');
include_once("inc/estructura/parte_superior.php");
include_once('config/dbconnect.php');
?>
<link rel="stylesheet" src="style.css" href="assets/css/servicio/servicio.css">
<link rel="stylesheet" src="style.css" href="assets/css/datatables/datatables.css">
<link rel="stylesheet" src="style.css" href="assets/css/bootstrap/bootstrap.css">
<style>
    .img-cliente img{
    width: 40px;
    height: 40px;
    border-radius: 50%;
  }
</style>
<div class="app-body-main-content" style="padding-top:10px;">



    <div class="main-content-bottom">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="ingreso-dia-mes" data-bs-toggle="tab" data-bs-target="#chart-barra-ingreso-dia-mes-container" type="button" role="tab" aria-controls="chart-barra-ingreso-dia-mes-container" aria-selected="true">Datos Caja Actual</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ingreso-mes-año" data-bs-toggle="tab" data-bs-target="#chart-barra-ingreso-mes-año-container" type="button" role="tab" aria-controls="chart-barra-ingreso-mes-año-container" aria-selected="false">Registro de cajas del Usuario</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ingreso-matricula-hoy" data-bs-toggle="tab" data-bs-target="#ingreso-mat-hoy" type="button" role="tab" aria-controls="ingreso-mat-hoy" aria-selected="false">Registro de cajas General</button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="chart-barra-ingreso-dia-mes-container" role="tabpanel" aria-labelledby="ingreso-dia-mes">


            <?php  

                    $codigo = $_SESSION['codigo'];

                                            
                    $sqldato = "select * from usuario us inner join caja cj on us.id_us = cj.id_us where us.id_us = '$codigo' and cier_caj is null";
                    $fdato = mysqli_query($cn, $sqldato);
                    $cant_usuario = mysqli_num_rows($fdato);

                    if($cant_usuario > 0){
                    

            ?>
                    <div class="col-md-12" style="background-color: white; padding: 1rem;">

                        <form action="caja/C_caja.php" method="post">
                        <div class="row">
                            
                            <div class="col-sm-6">
                                <h2>Datos del Usuario</h2>
                                <?php 

                                $rdato = mysqli_fetch_assoc($fdato);
                                $fecha_inicio = $rdato['aper_caj'];
                                ?>
                                <p>Nombre: </p>
                                <h3><?php echo $rdato['nombre_us'] ?></h3> 
                                <p>Usuario: </p>
                                <h3><?php echo $rdato['usuario_us'] ?></h3>
                                <p>Fecha y Hora Apertura: </p>
                                <h3><?php echo $rdato['aper_caj'] ?></h3>
                                <p>Estado: </p>
                                <h3><?php echo $rdato['estado'] ?></h3>
                                <p>Algo: </p>
                                <h3><?php echo $rdato['nombre_us'] ?></h3>

                            </div>

                            <div class="col-sm-6">
                                <h2>Datos Generales</h2>
                                <input type="text" name="codigo" value="<?php echo $codigo ?>" hidden>
                                
                            <?php  
                            date_default_timezone_set('America/Lima');
                            $fechaHora = date("Y-m-d H:i:s");
                            
                            $sql_dtp = "SELECT tp.desc_tp AS tipopago, 
                                           COALESCE(SUM(tpago.total), 0) AS total
                                    FROM tipo_pago tp
                                    LEFT JOIN (
                                        SELECT ap.id_tp, SUM(tr.precio_tiru) AS total
                                        FROM asistencia_pago ap
                                        INNER JOIN tipo_rutina tr ON ap.id_tiru = tr.id_tiru
                                        WHERE ap.fech_asip BETWEEN '$fecha_inicio' AND '$fechaHora'
                                        GROUP BY ap.id_tp

                                        UNION ALL

                                        SELECT ma.id_tp, SUM(men.precio_me) AS total
                                        FROM matricula ma
                                        INNER JOIN membresia men ON ma.id_me = men.id_me 
                                        WHERE ma.fecharegistro_ma BETWEEN '$fecha_inicio' AND '$fechaHora'
                                        GROUP BY ma.id_tp
                                    ) AS tpago ON tp.id_tp = tpago.id_tp
                                    GROUP BY tp.desc_tp;
                                        ";


                                    $sqltotal = "SELECT SUM(subquery.total) as dato
                                            FROM (
                                                SELECT COALESCE(SUM(tr.precio_tiru), 0) AS total
                                                FROM asistencia_pago ap
                                                INNER JOIN tipo_rutina tr ON ap.id_tiru = tr.id_tiru
                                                WHERE ap.fech_asip BETWEEN '$fecha_inicio' AND '$fechaHora'

                                                UNION ALL

                                                SELECT COALESCE(SUM(men.precio_me), 0) AS total
                                                FROM matricula ma
                                                INNER JOIN membresia men ON ma.id_me = men.id_me 
                                                WHERE ma.fecharegistro_ma BETWEEN '$fecha_inicio' AND '$fechaHora'
                                            ) AS subquery";

                                    $ftotal = mysqli_query($cn, $sqltotal);
                                    $rtotal = mysqli_fetch_assoc($ftotal);

                                    $dato = $rtotal['dato'];

                                    $f_dtp = mysqli_query($cn, $sql_dtp);

                                        ?>  


                                        <div class="content-left-earnings">
                                  <?php

                                  $sqlcant = "SELECT * FROM caja WHERE id_us = $codigo AND cier_caj IS NULL"; 

                                    $fcant = mysqli_query($cn, $sqlcant);

                                    $rcant = mysqli_fetch_assoc($fcant);
                                    $saldo_inicial =  $rcant['sal_inicial'];

                                    $dato_total = $saldo_inicial + $dato;
                                  $tipos_pago_predeterminados = array(
                                    'Yape' => '1.jpg',
                                    'Plin' => 'plin.png',
                                    'Efectivo' => 'efective.png'
                                  );
                                  while ($r_dtp = mysqli_fetch_assoc($f_dtp)) {
                                  ?>
                                    <div class="card-earnings-sol">
                                      <div class="card-earnings-title">
                                        <img class="img-card-tipos-pago" src="assets/images/tipoPago/<?php echo $tipos_pago_predeterminados[$r_dtp['tipopago']]; ?>" alt="" style = "width: 20px; height: 20px;">
                                        <p><?php echo $r_dtp['tipopago']; ?></p>
                                      </div>
                                      <h3 class="card-earnings-text" >
                                        <input type="text" class="input-number" style="font-weight: bold;" name="<?php echo $r_dtp['tipopago']; ?>" value="<?php echo $r_dtp['total']; ?>">
                                      </h3>
                                    </div>
                                  <?php
                                  }
                                  ?>
                                <p>Saldo Inicial:  </p>
                                <h3 class="card-earnings-text"><input type="text" name="sue_inicial"  style="font-weight: bold;" value="<?php echo $saldo_inicial?>"></h3>
                                <h3>--------------------------------------- </h3>
                                <p>Total: <input type="text" id="sumaTotal" name="txt_total" value="<?php echo $dato_total; ?>"></p>
                    </div>  


                            </div>

                        </div>
                           <input class="btn btn-primary"  type="submit" value="CERRAR CAJA">

                        </form>

                    </div>

            <?php  

                    }else{
            ?>





                    <div class="col-md-12" style="background-color: white; padding: 1rem;">
                    <center><h1>NO HA APERTURADO UNA CAJA</h1></center>

                 
                    <center><button  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      Abrir Caja
                    </button></center>

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Apertura de Caja</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          
                            <form action="caja/r_caja.php" method="post">
                                <div class="modal-body">
                                    
                                      <input type="" name="codigo" value="<?php echo $codigo ?> " hidden>
                                      <input type="" name="saldo"  placeholder="Ingrese el saldo Inicial">
                                      
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <input class="btn btn-primary"  type="submit" value="ABRIR CAJA">
                                </div>
                                </form>

                        </div>
                      </div>
                    </div>








                </div>
            <?php  
                    }
            ?>


   

        </div>
        <div class="tab-pane fade" id="chart-barra-ingreso-mes-año-container" role="tabpanel" aria-labelledby="ingreso-mes-año">
            

            <div class="col-md-12" style="background-color: white; padding: 1rem;">
    <div class="main-content">
        <div style="color: #f05941; font-weight: bolder; font-size: 3rem; text-align:center;">Registro de Cajas Del Usuario</div>
        <div class="col-md-12">
            <table class="table table-striped table_id" id="table_asistencia">
                <thead align="center" class="" style="color: #fff; background-color:#f05941;">
                    <tr align="center">
                        <th class="text-center"> Id </th>
                        <th class="text-center"> Apertura </th>
                        <th class="text-center"> Cierre </th>
                        <th class="text-center"> Saldo Inicial </th>
                        <th class="text-center"> Yape </th>
                        <th class="text-center"> Plin </th>
                        <th class="text-center"> Efectivo </th>
                        <th class="text-center"> Total </th>
                        <th class="text-center"> Estado </th>
                        <th class="text-center"> Usuario </th>
                        <th class="text-center"> OPCIONES </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('config/dbconnect.php');
                    $sql = "SELECT * FROM caja cj inner join usuario us on cj.id_us = us.id_us where cj.id_us = $codigo";
                    $f = mysqli_query($cn, $sql);
                    while ($r = mysqli_fetch_assoc($f)) {
                    ?>
                    <tr>
                        <td align="center"><?php echo $r['id_caj'] ?></td>
                        <td align="center"><?php echo $r['aper_caj'] ?></td>
                        <td align="center"><?php echo $r['cier_caj'] ?></td>
                        <td align="center"><?php echo $r['sal_inicial'] ?></td>
                        <td align="center"><?php echo $r['yape_caj'] ?></td>
                        <td align="center"><?php echo $r['plin_caj'] ?></td>
                        <td align="center"><?php echo $r['ejec_caj'] ?></td>
                        <td align="center"><?php echo $r['tot_caj'] ?></td>
                        <td align="center"><?php echo $r['estado'] ?></td>
                        <td align="center"><?php echo $r['usuario_us'] ?></td>
                        <td align="center">
                            <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalEditarCaja" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({'id':' <?php echo $r['id_caj'] ?? ''; ?> ','saldo':'<?php echo $r['sal_inicial'] ?? ''; ?>','estado':'<?php echo $r['estado'] ?? ''; ?>' })"><i class="fas fa-edit"></i></a>
                            <a href="caja/D_caja.php?cod=<?php echo $r['id_caj'] ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

        </div>

        <div class="tab-pane fade" id="ingreso-mat-hoy" role="tabpanel" aria-labelledby="ingreso-matricula-hoy">

            <div class="col-md-12" style="background-color: white; padding: 1rem;">
                <div class="main-content">
                    <div style="color: #f05941; font-weight: bolder; font-size: 3rem; text-align:center;">Registro de Cajas</div>
                    <div class="col-md-12">
                        <table class="table table-striped table_id" id="table_asistencia2">
                            <thead align="center" class="" style="color: #fff; background-color:#f05941;">
                                <tr align="center">
                                    <th class="text-center"> Id </th>
                                    <th class="text-center"> Apertura </th>
                                    <th class="text-center"> Cierre </th>
                                    <th class="text-center"> Saldo Inicial </th>
                                    <th class="text-center"> Yape </th>
                                    <th class="text-center"> Plin </th>
                                    <th class="text-center"> Efectivo </th>
                                    <th class="text-center"> Total </th>
                                    <th class="text-center"> Estado </th>
                                    <th class="text-center"> Usuario </th>
                                    <th class="text-center"> OPCIONES </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include('config/dbconnect.php');
                                $sql = "SELECT * FROM caja cj inner join usuario us on cj.id_us = us.id_us";
                                $f = mysqli_query($cn, $sql);
                                while ($r = mysqli_fetch_assoc($f)) {
                                ?>
                                <tr>
                                    <td align="center"><?php echo $r['id_caj'] ?></td>
                                    <td align="center"><?php echo $r['aper_caj'] ?></td>
                                    <td align="center"><?php echo $r['cier_caj'] ?></td>
                                    <td align="center"><?php echo $r['sal_inicial'] ?></td>
                                    <td align="center"><?php echo $r['yape_caj'] ?></td>
                                    <td align="center"><?php echo $r['plin_caj'] ?></td>
                                    <td align="center"><?php echo $r['ejec_caj'] ?></td>
                                    <td align="center"><?php echo $r['tot_caj'] ?></td>
                                    <td align="center"><?php echo $r['estado'] ?></td>
                                    <td align="center"><?php echo $r['usuario_us'] ?></td>
                                    <td align="center">
                                        <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalEditarCaja" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({'id':' <?php echo $r['id_caj'] ?? ''; ?> ','saldo':'<?php echo $r['sal_inicial'] ?? ''; ?>','estado':'<?php echo $r['estado'] ?? ''; ?>' })"><i class="fas fa-edit"></i></a>
                                        <a href="caja/D_caja.php?cod=<?php echo $r['id_caj'] ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>












<div class="modal fade" id="ModalEditarCaja" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR CAJAS:</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <form action="caja/U_caja.php" method="post">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="rol" class="col-form-label" style="color: black;">Cajas:</label>
                            <input type="text" name="txtcaja" class="form-control" id="txt_id" required disabled>
                            <input type="text" name="txtcaja2"  class="form-control" id="txt_id2" hidden>

                            <br>
                            <label for="rol" class="col-form-label" style="color: black;">Saldo Inicial:</label>
                            <input type="text" name="txtsaldo" class="form-control" id="txt_saldo" required>

                            <br>
                            <label for="Estado-name" class="col-form-label" style="color: black;">Estado:</label>
                            <select name="txtestado" id="txt_estado" class="form-control" aria-label="Default select example">
                                <option value="APERTURADO">APERTURADO</option>
                                <option value="FINALIZADO">FINALIZADO</option>
                            </select>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                <button type="submit" class="btn btn-primary" id="registrar" style="background-color:#f05941; border-color: #f05941;">MODIFICAR</button>
                <input type="hidden" name="id_us" id="id_ro" value="">
            </div>
            </form>
        </div>
    </div>
</div>
</div>




                        
<?php
include_once("inc/estructura/parte_inferior.php");
include_once('ticket_extension.php');
?>

<script type="text/javascript">
            function cargar_info(dato) {

document.getElementById('txt_id').value = dato.id;
document.getElementById('txt_id2').value = dato.id;
document.getElementById('txt_saldo').value = dato.saldo;

var generoSelect = document.getElementById('txt_estado');

for (var i = 0; i < generoSelect.options.length; i++) {
    if (generoSelect.options[i].value == dato.estado) {
        generoSelect.options[i].selected = true;
        break;
    }
}


}

      
let table = new DataTable('#table_asistencia', {
    language: {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast":"Último",
                    "sNext":"Siguiente",
                    "sPrevious": "Anterior"
			     },
			     "sProcessing":"Procesando...",
            }   ,
        //para usar los botones   
        responsive: "true",
        dom: 'Bfrtilp',       
        buttons:[ 
			{
				extend:    'excelHtml5',
				text:      '<i class="fa-regular fa-file-excel"></i> ',
				titleAttr: 'Exportar a Excel',
				// className: 'btn btn-success'
			},
			{
				extend:    'pdfHtml5',
				text:      '<i class="fa-regular fa-file-pdf"></i>',
				titleAttr: 'Exportar a PDF',
				// className: 'btn btn-danger',
                orientation: 'landscape' 
			},
			{
				extend:    'print',
				text:      '<i class="fa-solid fa-print"></i>',
				titleAttr: 'Imprimir',
				// className: 'btn btn-info'
			},
		]	      

});

let table2 = new DataTable('#table_asistencia2', {
    language: {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast":"Último",
                    "sNext":"Siguiente",
                    "sPrevious": "Anterior"
			     },
			     "sProcessing":"Procesando...",
            }   ,
        //para usar los botones   
        responsive: "true",
        dom: 'Bfrtilp',       
        buttons:[ 
			{
				extend:    'excelHtml5',
				text:      '<i class="fa-regular fa-file-excel"></i> ',
				titleAttr: 'Exportar a Excel',
				// className: 'btn btn-success'
			},
			{
				extend:    'pdfHtml5',
				text:      '<i class="fa-regular fa-file-pdf"></i>',
				titleAttr: 'Exportar a PDF',
				// className: 'btn btn-danger',
                orientation: 'landscape' 
			},
			{
				extend:    'print',
				text:      '<i class="fa-solid fa-print"></i>',
				titleAttr: 'Imprimir',
				// className: 'btn btn-info'
			},
		]	      

});
</script>