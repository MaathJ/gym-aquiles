<?php
include_once("inc/estructura/parte_superior.php");
include_once('config/dbconnect.php');
?>


<!-- Page-header end -->
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
                                <div class="col-md-4">

                                    <button type="button" class="btn btn-lg " style="background: #17a2b8;" data-bs-toggle="modal" data-bs-target="#ModalrolRegistro" data-bs-whatever="@mdo">
                                    <i class="fa-solid fa-plus text-white" ></i><span class="text-white"> Nuevo Turno</span>
                                    </button>

                                  

                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>

                            </div>
                        </div>
                        <br>

                        <div class="col-md-12">
                            <table class="table table-striped"  id="table_Turno">
                                <thead align="center" class=""  style="color: #fff; background-color:#17a2b8;">
                                    <tr>
                                        <th>ID</th>
                                        <th>TURNO</th>
                                        <th>ESTADO</th>
                                        <th>OPCIONES</th>
                                    </tr>


                                </thead>
                                <tbody>
                                    <?php
                                  
                                    $sql = "SELECT * FROM turno as r";
                                    $f = mysqli_query($cn, $sql);
                                    while ($r = mysqli_fetch_assoc($f)) {


                                    ?>

         

                                        <tr>
                                            <td><?php echo $r['id_tu']?></td>
                                            <td><?php echo $r['nombre_tu']?></td>
                                            <td><?php echo $r['estado_tu']?></td>
                                            <td>
                                            <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalrolEditar" 
                                            data-bs-whatever="@mdo" target="_parent" onclick=" cargar_info({
                                                'id':' <?php echo $r['id_tu'] ?? ''; ?> ',
                                                'nombre':'<?php echo $r['nombre_tu']??'';?>',
                                                'estado':'<?php echo $r['estado_tu']??'';?>'
                                            } )"  >
                                                <i class="fas fa-edit"> </i></a>



                                                <a href="Turno/D_turno.php?cod=<?php echo $r['id_tu']?>" class="btn btn-sm btn-danger" target="parent"><i class="fas fa-trash"> </i></a>
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
            <!-- Page-body end -->
        </div>
        <div id="styleSelector"> </div>
    </div>
</div>



<!-- MODAL PARA EDITAR ROLES  -->
<div class="modal fade  " id="ModalrolEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #0B5ED7; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR TURNO:</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <form action="Turno/U_turno.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rol" class="col-form-label" style="color: black;">Turno:</label>
                                <input type="text" name="txtnombre" placeholder="Ingrese el Turno" class="form-control" id="txt_nombre" required>
                                <input type="text" name="txtid" placeholder="Ingrese el Turno" class="form-control" id="txt_id" hidden>
                            </div>



                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                    <label for="Estado-name" class="col-form-label" style="color: black;">Estado:</label>
                                    <select name="txtestado" id="txt_estado" class="form-select" aria-label="Default select example">
                                        <option value="ACTIVO">ACTIVO</option>
                                        <option value="INACTIVO">INACTIVO</option>
                                    </select>

                                  
                                </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="registrar">MODIFICAR</button>
                        <input type="hidden" name="id_us" id="id_ro" value="">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Page-body end -->
</div>

<!-- MODAL PARA REGISTRO ROLES  -->
<div class="modal fade  " id="ModalrolRegistro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #0B5ED7; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">REGISTRO ROL:</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <form action="turno.php" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rol" class="col-form-label" style="color: black;">Turno:</label>
                                <input type="text" name="turno" placeholder="Ingrese el Turno" class="form-control" id="turno" required>
                            </div>


                        </div>

                        <div class="col-md-6">


                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="registrar">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Page-body end -->
</div>

<script>    

    function cargar_info(dato) {
           


            document.getElementById('txt_nombre').value= dato.nombre; 
      
            document.getElementById('txt_id').value=dato.id;


            var generoSelect2 = document.getElementById('txt_estado');

            for (var i = 0; i < generoSelect2.options.length; i++) {
                if (generoSelect2.options[i].value == dato.estado) {
                    generoSelect2.options[i].selected = true;
                    break;
                }
            }

        }

    
let table = new DataTable('#table_Turno', {
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

if (isset($_GET['turno'])) {
   
    $nombre_tur = strtoupper($_GET['turno']) ;
   

    $sqlrol ="INSERT INTO Turno (nombre_tu, estado_tu) VALUES('$nombre_tur', 'ACTIVO')";
    mysqli_query($cn,$sqlrol);

    echo '<script>window.location.href = "turno.php";</script>';

}

?>



<?php
require_once "inc/estructura/parte_inferior.php"

?>