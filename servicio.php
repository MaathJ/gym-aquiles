<?php
include_once("inc/estructura/parte_superior.php");
include_once('config/dbconnect.php');
?>
<link rel="stylesheet" src="style.css" href="assets/css/servicio/servicio.css">
<link rel="stylesheet" src="style.css" href="assets/css/datatables/datatables.css">
<link rel="stylesheet" src="style.css" href="assets/css/bootstrap/bootstrap.css">
<div class="app-body-main-content">
    <div>
        <p>Pages<span> / Servicio</span></p>
        <h3>Servicio</h3>
    </div>
    <div class="main-content">
        <div>
            <button class="servicio" data-bs-toggle="modal" data-toggle="modal" data-target="#R_servicio">
            Nuevo Servicio
            </button>
        </div>
        <div class="col-md-12">
                            <table class="table table-striped"  id="table_servicio">
                                <thead class=""  style="color: #fff; background-color:#f05941;">
                                    <tr>
                                        <th class="text-center">Id</th>
                                        <th class="text-center">SERVICIO</th>
                                        <th class="text-center">OPCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                $sql = "select * from servicio";

                                $f = mysqli_query($cn, $sql);
                                while ($r = mysqli_fetch_assoc($f)) {
                                ?>
                                    <tr>
                                        <td align="center">
                                            <?php echo $r['id_se']; ?>
                                        </td>
                                        <td align="center">
                                            <?php echo $r['nombre_se']; ?>
                                        </td>
                                        <td align="center">
                                            <!-- BOTON EDITAR -->
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#U_servicio<?php echo $r['id_se']; ?>"><i class="fas fa-edit"> </i></a></button>

                                            <!-- MODAL PARA EDITAR  -->
                                            <div class="modal fade" id="U_servicio<?php echo $r['id_se']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header " style="background-color: #F39C12; color: #ffffff;">
                                                            <h4 class="modal-title" id="exampleModalLabel">Editar Servicio</h4>
                                                            <button type="button" class="btn-close" style="background-color: #ffffff;" data-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <form action="membresia/U_servicio.php" method="post">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="recipient-name" class="col-form-label" style="color: black;">Nombre:</label>
                                                                            <input type="text" name="txt_id" class="form-control" id="recipient-name" required value="<?php echo $r['id_se']; ?>" hidden>
                                                                            <input type="text" name="txt_nomb" class="form-control" id="recipient-name" required maxlength="10" value="<?php echo $r['nombre_se']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                    <button type="submit" class="btn btn-primary">Editar</button>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- BOTON ELIMINAR -->
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#D_servicio<?php echo $r['id_se']; ?>"><i class="fas fa-trash"> </i></button>

                                           <!-- MODAL PARA ELIMINAR  -->
<div class="modal fade" id="D_servicio<?php echo $r['id_se']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #EC7063; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">¡ADVERTENCIA! SE ELIMINARÁ EL SIGUIENTE SERVICIO</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="delete-service-form" action="membresia/D_servicio.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <input type="hidden" name="txt_id" class="service-id" value="<?php echo $r['id_se']; ?>">
                                <label for="recipient-name" class="col-form-label" style="color: black;">Nombre:</label>
                                <label for="recipient-name" class="col-form-label" style="color: black;">
                                    <?php echo $r['nombre_se']; ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-danger">CONFIRMAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>

                        </div>
</div>

<!-- MODAL PARA REGISTRO  -->
<div class="modal fade" id="R_servicio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #F39C12; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">REGISTRAR NUEVO SERVICIO</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="R_servicio_form" method="post" action="membresia/R_servicio.php">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label" style="color: black;">Nombre:</label>
                                <input type="text" name="txt_nomb" class="form-control" id="recipient-name" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary">REGISTRAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





<?php
include_once("inc/estructura/parte_inferior.php")
?>

<script type="text/javascript">
            function cargar_info(dato) {
            if (dato.genero === undefined || dato.genero === null) {
                console.error("La propiedad 'genero' en 'dato' es nula o indefinida.");
                return;
            }
            document.getElementById('recipient_name').value = dato.id_cli;
            document.getElementById('recipient_name2').value = dato.id_cli;
            document.getElementById('nombre_name').value = dato.nombre;
            document.getElementById('Apellido_name').value = dato.apellido;
            document.getElementById('Telefono_name').value = dato.telefono;

            document.getElementById('Edad_name').value = dato.edad;
            document.getElementById('Direccion_name').value = dato.direccion;
          
            document.getElementById('Dni_name').value = dato.dni;
            document.getElementById('Enfermedad_name').value = dato.enfermedad;
            document.getElementById('txt_genero').value = dato.genero;

            var generoSelect = document.getElementById('Genero_name2');

            for (var i = 0; i < generoSelect.options.length; i++) {
                if (generoSelect.options[i].value == dato.genero) {
                    generoSelect.options[i].selected = true;
                    break;
                }
            }

            var generoSelect2 = document.getElementById('txt_estado');

            for (var i = 0; i < generoSelect2.options.length; i++) {
                if (generoSelect2.options[i].value == dato.estado) {
                    generoSelect2.options[i].selected = true;
                    break;
                }
            }

            document.getElementById('img2').src = "assets/images/cliente/" + dato.dni + ".jpg";


        }

      
let table = new DataTable('#table_servicio', {
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function(){
        console.log("Script de registro de servicio cargado.");
        $('#R_servicio_form').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                type: 'POST',
                url: 'membresia/R_servicio.php',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            title: '¡Registro exitoso!',
                            text: response.message,
                            icon: 'success'
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: '¡Error!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function(){
        console.log("Script de eliminación de servicio cargado.");
        $('.delete-service-form').submit(function(e) {
            e.preventDefault();
            
            var serviceId = $(this).find('.service-id').val();
            
            // Ejecutar directamente la solicitud AJAX para eliminar el servicio
            $.ajax({
                type: 'POST',
                url: 'membresia/D_servicio.php',
                data: { txt_id: serviceId },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: response.message,
                            icon: 'success'
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: '¡Error!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                }
            });
        });
    });
</script>







