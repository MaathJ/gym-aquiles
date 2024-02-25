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
    <div>
        <p>Pages<span> / Asistencias Matriculados</span></p>
        <h3>Asistencias Matriculados</h3>
    </div>
    <br>
    <div class="col-md-12" style="background-color: white; padding: 1rem; border-radius: 1rem;">
    <div class="main-content">
        <div style="color: #f05941; font-weight: bolder; font-size: 3rem; text-align:center;">Asistencias De Matriculados</div>
        <div class="col-md-12">
                            <table class="table table-striped table_id" id="table_asistencia">

                                <thead align="center" class="" style="color: #fff; background-color:#f05941;">
                                    <tr align="center">
                                        <th class="text-center"> ID </th>
                                        <th class="text-center"> Foto </th>
                                        <th class="text-center"> Matriculado </th>
                                        <th class="text-center"> DNI </th>
                                        <th class="text-center"> Membresia </th>
                                        <th class="text-center"> Fecha Registro </th>
                                    </tr>
                                </thead>
                                <?php
                                include('config/dbconnect.php');
                                $sql = "SELECT asi.*, ma.*, me.*, se.*, cli.*, us.*
                                FROM asistencia as asi 
                                INNER JOIN matricula as ma ON asi.id_ma=ma.id_ma
                                INNER JOIN membresia me ON ma.id_me = me.id_me
                                INNER JOIN servicio se ON me.id_se = se.id_se
                                INNER JOIN cliente cli ON ma.id_cli = cli.id_cli
                                INNER JOIN usuario us ON ma.id_us = us.id_us
                                ORDER BY fecha_as DESC";
                                $f = mysqli_query($cn, $sql);
                                while ($r = mysqli_fetch_assoc($f)) {


                                ?>
                                    
                                    <td align="center"><?php echo $r['id_as'] ?></td>
                                    <td align="center">
                                        <p class="img-cliente">
                                            <img src="assets/images/cliente/<?php echo $r['dni_cli']; ?>.jpg" alt="">
                                        </p>
                                    </td>
                                    <td align="center"><?php echo $r['apellido_cli'] . ' ,' . $r['nombre_cli'] ?></td>
                                    <td align="center"><?php echo $r['dni_cli'] ?></td>
                                    <td align="center"><?php echo $r['nombre_me'] . '</br> ( ' . $r['nombre_se'] . ')'  ?></td>
                                    <td align="center"><?php echo date('d-m-Y H:i:s',strtotime($r['fecha_as']))  ?></td>

                                    <!-- <td>
                                    </td> -->

                                    </tr>
                                <?php
                                }
                                ?>



                            </table>
                        </div>
    </div>  
</div>
</div>

                        
<?php
include_once("inc/estructura/parte_inferior.php")
?>

<script type="text/javascript">
            function cargar_info(dato) {

document.getElementById('recipient_name').value = dato.id;
document.getElementById('recipient_name2').value = dato.id;
document.getElementById('nombre_name').value = dato.nombre;
document.getElementById('Fecha_name').value = dato.fecha;

var generoSelect = document.getElementById('rutina_name');

for (var i = 0; i < generoSelect.options.length; i++) {
    if (generoSelect.options[i].value == dato.rutina) {
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