<?php
include_once('auth.php');
include_once("inc/estructura/parte_superior.php");
include('config/dbconnect.php');
?>
<link rel="stylesheet" src="style.css" href="assets/css/roles/roles.css">
<link rel="stylesheet" src="style.css" href="assets/css/datatables/datatables.css">
<link rel="stylesheet" src="style.css" href="assets/css/bootstrap/bootstrap.css">
<div class="app-body-main-content">
    <div>
        <p>Pages<span> / Roles</span></p>
        <h3>Roles</h3>
    </div>
    <div class="main-content">
        <div>
            <button class="roles" data-bs-toggle="modal" data-bs-target="#ModalrolRegistro" data-bs-whatever="@mdo">
            Nuevo Rol
            </button>
        </div>
        <div class="col-md-12" style="background-color: white; padding: 1rem; border-radius: 1rem;">
                            <table class="table table-striped"  id="table_rol">
                                <thead align="center" class=""  style="color: #fff; background-color:#f05941;">
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">ROL</th>
                                        <th class="text-center">OPCIONES</th>
                                    </tr>


                                </thead>
                                <tbody>
                                    <?php
                                  
                                    $sql = "SELECT * FROM rol as r";
                                    $f = mysqli_query($cn, $sql);
                                    while ($r = mysqli_fetch_assoc($f)) {


                                    ?>

                                        <tr>
                                            <td align="center"><?php echo $r['id_ro']?></td>
                                            <td align="center"><?php echo $r['nombre_ro']?></td>
                                            <td align="center">
                                            <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalrolEditar" 
                                            data-bs-whatever="@mdo" target="_parent" onclick=" cargar_info({
                                                'id':' <?php echo $r['id_ro'] ?? ''; ?> ',
                                                'nombre':'<?php echo $r['nombre_ro']??'';?>'
                                            } )"  >
                                                <i class="fas fa-edit"> </i></a>


                                                <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#ModalEliminar" data-bs-whatever="@mdo" onclick=" cargar_info2({
                                                'id':' <?php echo $r['id_ro'] ?? ''; ?> ',
                                            } )"><i class="fas fa-trash"> </i></a>

                                            </td>
                                        </tr>
                                    <?php
                                    }

                                    ?>


                                </tbody>
                            </table>


                        </div>
</div>

<!-- MODAL PARA EDITAR ROLES  -->

<div class="modal fade" id="ModalrolEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR ROL:</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <form action="rol/U_rol.php" method="post">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="rol" class="col-form-label" style="color: black;">Rol:</label>
                            <input type="text" name="txtnombre" placeholder="Ingrese el Rol" class="form-control" id="txt_nombre" required>
                            <input type="text" name="txtid" placeholder="Ingrese el Rol" class="form-control" id="txt_id" hidden>
                            
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
<!-- Page-body end -->
</div>

<!-- MODAL PARA REGISTRO ROLES  -->
<div class="modal fade  " id="ModalrolRegistro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">REGISTRO DE ROL:</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <form action="rol/R_rol.php" method="post">
                    <div class="row">
                        <div class="col-12 mb-3">
                                <label for="rol" class="col-form-label" style="color: black;">Rol:</label>
                                <input type="text" name="rol" placeholder="Ingrese el Rol" class="form-control" id="rol" required>
                            </div>


                        </div>

                        <div class="col-md-6">


                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="registrar" style="background-color:#f05941; border-color: #f05941;">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Page-body end -->
</div>

<!-- MODAL PARA ELIMINAR  -->
<div class="modal fade  " id="ModalEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header "style="background-color: #f05941; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">CONFIRMAR ELIMINACIÓN:</h4>

              
            </div>
            <div class="modal-body">
                <form action="rol/D_rol.php" method="post">
                                ¿Está seguro que desea eliminar el rol seleccionado?
                                <input type="text" name="cod_rol2" id="cod_rol2" class="form-control" hidden>
                        <div class=modal-footer>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                            <button type="submit" class="btn btn-danger" id="">ELIMINAR</button>
                            <input type="hidden" name="id_us" id="id_us" value="">
                        </div>
                    </div>
                </form>
            </div>



        </div>
    </div>
</div>


<?php
if (isset($_SESSION['success_message'])) {
    echo
    '<script>
    setTimeout(() => {
        Swal.fire({
            title: "¡Éxito!",
            text: "' . $_SESSION['success_message'] . '",
            icon: "success"
        });
    }, 200);
</script>';
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['deleted_ro'])) {
    echo
    '<script>
    setTimeout(() => {
        Swal.fire({
            title: "¡Éxito!",
            text: "' . $_SESSION['deleted_ro'] . '",
            icon: "success"
        });
    }, 500);
</script>';
    unset($_SESSION['deleted_ro']);
}


if (isset($_SESSION['error_ro'])) {
    echo
    '<script>
    setTimeout(() => {
        Swal.fire({
            title: "¡Error!",
            text: "' . $_SESSION['error_ro'] . '",
            icon: "error"
        });
    }, 500);
    </script>';
    unset($_SESSION['error_ro']);
}

if (isset($_SESSION['alert_message'])) {
    $alertMessage = $_SESSION['alert_message'];
    echo '<script>
    setTimeout(() => {
        Swal.fire({
            title: "¡Cuidado!",
            text: "' . $alertMessage . '",
            icon: "warning"
        });
    }, 500);
    </script>';
    unset($_SESSION['alert_message']);
}

?>


<?php
include_once("inc/estructura/parte_inferior.php")
?>

<script type="text/javascript">

function cargar_info2(dato) {

document.getElementById('cod_rol2').value = dato.id;
}

function cargar_info(dato) {
        
        document.getElementById('txt_nombre').value= dato.nombre; 
  
        document.getElementById('txt_id').value=dato.id;
      
    }
      
let table = new DataTable('#table_rol', {
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




