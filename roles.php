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
        <p>Pages<span> / Rutina</span></p>
        <h3>Rutina</h3>
    </div>
    <div class="main-content">
        <div>
            <button class="roles" data-bs-toggle="modal" data-bs-target="#ModalrolRegistro" data-bs-whatever="@mdo">
            Nuevo Rutina
            </button>
        </div>
        <div class="col-md-12">
                            <table class="table table-striped"  id="table_rol">
                                <thead align="center" class=""  style="color: #fff; background-color:#f05941;">
                                    <tr>
                                        <th>ID</th>
                                        <th>ROL</th>
                                        <th>OPCIONES</th>
                                    </tr>


                                </thead>
                                <tbody>
                                    <?php
                                  
                                    $sql = "SELECT * FROM rol as r";
                                    $f = mysqli_query($cn, $sql);
                                    while ($r = mysqli_fetch_assoc($f)) {


                                    ?>

                                        <tr>
                                            <td><?php echo $r['id_ro']?></td>
                                            <td><?php echo $r['nombre_ro']?></td>
                                            <td>
                                            <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalrolEditar" 
                                            data-bs-whatever="@mdo" target="_parent" onclick=" cargar_info({
                                                'id':' <?php echo $r['id_ro'] ?? ''; ?> ',
                                                'nombre':'<?php echo $r['nombre_ro']??'';?>'
                                            } )"  >
                                                <i class="fas fa-edit"> </i></a>



                                                <a href="rol/D_rol.php?cod=<?php echo $r['id_ro']?>" class="btn btn-sm btn-danger" target="parent"><i class="fas fa-trash"> </i></a>
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
<div class="modal fade  " id="ModalrolEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #0B5ED7; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR ROL:</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <form action="roles.php" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rol" class="col-form-label" style="color: black;">Rol:</label>
                                <input type="text" name="rol" placeholder="Ingrese el Rol" class="form-control" id="rol" required>
                            </div>


                        </div>

                        <div class="col-md-6">


                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="registrar">Registrar</button>
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


                <form action="roles.php" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rol" class="col-form-label" style="color: black;">Rol:</label>
                                <input type="text" name="rol" placeholder="Ingrese el Rol" class="form-control" id="rol" required>
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

<?php
include_once("inc/estructura/parte_inferior.php")
?>

<script type="text/javascript">
function cargar_info(dato) {
        
        document.getElementById('rol').value= dato.nombre; 
  
        document.getElementById('id_ro').value=dato.id;
      
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
<?php 

if (isset($_GET['rol'])) {
   
    $rol = strtoupper($_GET['rol']) ;
   

    $sqlrol ="INSERT INTO rol (nombre_ro) VALUES('$rol')";
    mysqli_query($cn,$sqlrol);

    echo '<script>window.location.href = "roles.php";</script>';

}

?>



