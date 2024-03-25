<?php
include_once('auth.php');
include_once("inc/estructura/parte_superior.php");
include('config/dbconnect.php');
?>
<link rel="stylesheet" src="style.css" href="assets/css/roles/roles.css">
<link rel="stylesheet" src="style.css" href="assets/css/datatables/datatables.css">
<link rel="stylesheet" src="style.css" href="assets/css/bootstrap/bootstrap.css">

<?php
    //ALERTAS
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

    if (isset($_SESSION['deleted_message'])) {
        echo
        '<script>
            setTimeout(() => {
                Swal.fire({
                    title: "¡Éxito!",
                    text: "' . $_SESSION['deleted_message'] . '",
                    icon: "success"
                });
            }, 500);
        </script>';
        unset($_SESSION['deleted_message']);
    }

    if (isset($_SESSION['error_message'])) {
        echo
        '<script>
            setTimeout(() => {
                Swal.fire({
                    title: "¡No se puede eliminar!",
                    text: "' . $_SESSION['error_message'] . '",
                    icon: "error"
                });
            }, 500);
        </script>';
        unset($_SESSION['error_message']);
    }

    if (isset($_SESSION['alert_message'])) {
        $alertMessage = $_SESSION['alert_message'];
        echo 
        '<script>
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

<div class="app-body-main-content">
    <div>
        <p>Pages<span> / Tipo de Pago</span></p>
        <h3>Tipo de Pago</h3>
    </div>
    <div class="main-content">
        <div>
            <button class="roles" data-bs-toggle="modal" data-bs-target="#ModalrolRegistro" data-bs-whatever="@mdo">
            Nuevo tipo de pago
            </button>
        </div>
        <div class="col-md-12" style="background-color: white; padding: 1rem; border-radius: 1rem;">
            <table class="table table-striped"  id="table_rol">
                <thead align="center" class=""  style="color: #fff; background-color:#f05941;">
                    <tr>
                        <th class="text-center">IMAGEN</th>
                        <th class="text-center">DESCRIPCIÓN</th>
                        <th class="text-center">OPCIONES</th>
                    </tr>


                </thead>
                <tbody>
                    <?php

                    $sql = "SELECT * FROM tipo_pago";
                    $f = mysqli_query($cn, $sql);
                    while ($r = mysqli_fetch_assoc($f)) {
                    ?>

                        <tr>
                            <td align="center">
                                <img src="assets/images/tipoPago/<?php echo $r['id_tp']; ?>.jpg" onerror="this.src='assets/images/tipoPago/desconocido.jpg'" width="40" height="40">
                            </td>
                            <td align="center"><?php echo $r['desc_tp']?></td>
                            <td align="center">
                            <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalTPEditar"
                            data-bs-whatever="@mdo" target="_parent" onclick=" cargar_edit({
                                'id':'<?php echo $r['id_tp'] ?? ''; ?>',
                                'nombre':'<?php echo $r['desc_tp']??'';?>'
                                } )"  >
                                <i class="fas fa-edit"> </i></a>

                            <a class="btn btn-sm btn-danger btn-circle" data-bs-toggle="modal" data-bs-target="#ModalTPEliminar"
                                data-bs-whatever="@mdo" target="_parent" onclick=" cargar_dele({
                                'id':'<?php echo $r['id_tp'] ?? ''; ?>'
                                } )"  >
                                <i class="fas fa-trash"> </i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL PARA EDITAR TIPO DE PAGO  -->
<div class="modal fade  " id="ModalTPEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR TIPO DE PAGO:</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="tipopago/U_tp.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="desc" class="col-form-label" style="color: black;">Descripción:</label>
                                <input type="text" name="desc" placeholder="Ingrese el Rol" class="form-control" id="desc" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <img id="img" width="200" height="200" onerror="this.src='assets/images/img_fond.jpg'">
                                <input type="file" name="foto" id="foto" accept="image/*" style="display: none">
                                <label class="btn_img btn-danger" for="foto">CAMBIAR FOTO</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="registrar">GUARDAR</button>
                        <input type="hidden" name="id" id="id_tp">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Page-body end -->
</div>

<!-- MODAL PARA REGISTRO TP  -->
<div class="modal fade  " id="ModalrolRegistro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">REGISTRO TIPO DE PAGO:</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="tipopago/R_tp.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label" style="color: black;">Descripción:</label>
                                <input type="text" name="desc" placeholder="Ingrese una descripción" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <img src="assets/images/img_fond.jpg" alt="avatar" id="img2" width="200" height="200">
                                <input type="file" name="foto2" id="foto2" accept="image/*" style="display: none">
                                <label class="btn_img btn-danger" for="foto2">CAMBIAR FOTO</label>
                            </div>
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

<!-- MODAL PARA ELIMINAR TP -->
<div class="modal fade" id="ModalTPEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">¡ADVERTENCIA! Se eliminara el siguiente registro</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="tipopago/D_tp.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label" style="color: black;">El registro eliminado no se podrá recuperar</label>
                                <input type="hidden" name="txt_id" class="form-control" id="d_id">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-danger">CONFIRMAR</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php
include_once("inc/estructura/parte_inferior.php")
?>

<script src="assets/js/imagenes/imagenes2.js"></script>
<script src="assets/js/imagenes/imagenes.js"></script>
<script type="text/javascript">
function cargar_edit(dato) {
    document.getElementById('desc').value= dato.nombre;
    document.getElementById('id_tp').value=dato.id;
    document.getElementById('img').src = "assets/images/tipoPago/"+dato.id +".jpg";
}

function cargar_dele(dato) {
    document.getElementById('d_id').value=dato.id;
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

<style type="text/css">
    .btn_img {
        width: 200px;
        text-align: center;
        border-radius: 10px;
        margin-top: 5px;
        padding-top: 5px;
        height: 35px;
    }
</style>