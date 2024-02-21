<?php
include_once("./inc/estructura/parte_superior.php");
include_once('config/dbconnect.php');

?>
    <script type="text/javascript" src="assets/js/jquery/jquery.min.js "></script>

<div class="pcoded-inner-content">
    <!-- Main-body start -->
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page-body start -->
            <div class="page-body">
                <div class="row">
                    <div class="container">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="text-title">ASISTENCIA OPERARIO</h3>
                                    <input type="text" class="form-control" placeholder="Ingrese el codigo de DNI" name="" id="buscador">
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="col-md-12">

                                            <!-- <a href="#" class="btn btn-sm btn-primary"> Ver Asistencias</a> -->

                                            <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Ver Asistencias</button>

                                        </div>
                                        <div class="col-md-12 modal-ope d-none">
                                             <div class="seconds-left">10</div>
                                            <h3 class="text-title"> Informacion del Operador</h3>
                                            <img style="border-radius: 50%; width:  180px;"  src="" id="peradorimg" alt="">
                                            <h5>Nombre:</h5> <span id="operadorNombre"></span>
                                            <h5>Apellido:</h5> <span id="operadorApellido"></span>
                                            <h5>ESTADO:</h5> <span id="operadorEstado"></span>
                                            <h5>FECHA Y HORA :</h5> <span id="operadorFechaHora"></span>
                                            
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Registros de Asistencia</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       
      
    

      <table class="table table-striped" id="table_asistencia">
        <thead>
            <tr>
                <th>ID</th>
                <th>OPERARIO</th>
                <th>DNI</th>
                <th>TURNO</th>
                <th>ESTADO</th>
                <th>FECHA Y HORA</th>
                <th>OPCIONES</th>
            </tr>
   

        </thead>
        <tbody>

        <?php 
         $sqlAsis = "SELECT asp.*, op.* ,tu.*  FROM asistenciaop asp INNER JOIN operario op
            ON asp.id_op = op.id_op INNER JOIN turno tu 
            ON op.id_tu =tu.id_tu
            ";
         $fas = mysqli_query($cn,$sqlAsis);
         while ($ras = mysqli_fetch_assoc($fas)) {
            
        
        ?>

         <tr>
            <td><?php echo $ras['id_aop']?></td>
            <td><?php echo $ras['apellido_op'] .' '.$ras['nombre_op']?></td>
            <td><?php echo $ras['dni_op'] ?></td>
            <td><?php echo $ras['nombre_tu'] ?></td>
            <td><?php echo $ras['estado_aop'] ?></td>
            <td><?php echo $ras['fecha_aop']?></td>
            <td></td>
         </tr>

         <?php 
          }
         ?>

        </tbody>
      </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Open second modal</button>
      </div>
    </div>
  </div>
</div>

<style>
.modal-ope{
    margin: 10px 10px;
    border:1px solid #020001;
    padding: 20px;
    border-radius:  30px;
    background-color: white;
}

</style>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
 $(document).ready(function () {
    $('#buscador').on('keydown', function (event) {
        if (event.which === 13) {
            event.preventDefault();
            search();
        }
    });

    function search() {
        var searchTerm = $('#buscador').val();

        if (searchTerm.length >= 8) {
            $.ajax({
                type: 'POST',
                url: 'buscadorop.php',
                data: { searchTerm: searchTerm },
                dataType: 'json',
                success: function (response) {
                    if (response.error) {
                        // Mostrar modal de alerta en caso de error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.error
                        });
                    } else {
                        $('#operadorNombre').text(response.nombre);
                        $('#operadorApellido').text(response.apellido);
                        $('#operadorEstado').text(response.estado);
                        $('#operadorFechaHora').text(response.fechaHora);
                        $('#peradorimg').attr('src', 'assets/images/operario/' + response.dni + '.jpg');
                        

                        // Mostrar modal con la información del operador y el estado
                        $('.modal-ope').removeClass('d-none');

                        // Después de 10 segundos, volver a ocultar el modal
                        var secondsLeft = 10;
                        var countdown = setInterval(function() {
                            $('.seconds-left').text(secondsLeft);
                            secondsLeft--;
                            if (secondsLeft < 0) {
                                clearInterval(countdown);
                                $('.modal-ope').addClass('d-none');
                            }
                        }, 1000);

                        Swal.fire({
                            icon: 'success',
                            title: 'REGISTRO DE  ' + response.estado,
                            text: '',
                            timer: 3000, // 10 segundos
                            timerProgressBar: true,
                            onBeforeOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    }
                    // Limpiar el input después de la búsqueda
                    $('#buscador').val('');
                },
                error: function () {
                    // Mostrar modal de alerta en caso de error de conexión
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al procesar la solicitud'
                    });
                }
            });
        } else {
            // Mostrar modal de alerta si la búsqueda no cumple con la longitud requerida
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Ingrese al menos 8 caracteres'
            });
        }
    }
});


</script>


<script>

         
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
				text:      '<i class="fas fa-file-excel"></i> ',
				titleAttr: 'Exportar a Excel',
				className: 'btn btn-success'
			},
			{
				extend:    'pdfHtml5',
				text:      '<i class="fas fa-file-pdf"></i> ',
				titleAttr: 'Exportar a PDF',
				className: 'btn btn-danger',
                orientation: 'landscape' 
			},
			{
				extend:    'print',
				text:      '<i class="fa fa-print"></i> ',
				titleAttr: 'Imprimir',
				className: 'btn btn-info'
			},
		]	      

});
</script>
<?php
include_once('./inc/estructura/parte_inferior.php')
?>
<style>

    .seconds-left{
        font-size: 20px;
        background-color: #020001;
        color: greenyellow;
        padding: 5px;
        border-radius: 20px;
        width: 25px;
    }
</style>