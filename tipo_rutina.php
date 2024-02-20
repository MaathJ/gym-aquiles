<?php
include_once("inc/estructura/parte_superior.php");
include_once('config/dbconnect.php');
?>
<link rel="stylesheet" src="style.css" href="assets/css/servicio/servicio.css">
<link rel="stylesheet" src="style.css" href="assets/css/datatables/datatables.css">
<link rel="stylesheet" src="style.css" href="assets/css/bootstrap/bootstrap.css">
<div class="app-body-main-content">
    <div>
        <p>Pages<span> / Tipo Rutina</span></p>
        <h3>Tipo Rutina</h3>
    </div>
    <div class="main-content">
        <div>
            <button class="servicio" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                Nuevo Tipo Rutina
            </button>
        </div>
        <div class="col-md-12">
            <table class="table table-striped" id="table_tiporutina">

                <thead align="center" class="" style="color: #fff; background-color:#f05941;">
                    <tr>
                        <th> CODIGO </th>
                        <th> NOMBRE </th>
                        <th> PRECIO </th>
                        <th> OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('config/dbconnect.php');
                    $sql = "select * from tipo_rutina";
                    $f = mysqli_query($cn, $sql);
                    while ($r = mysqli_fetch_assoc($f)) {


                    ?>

                        <td align="center"><?php echo $r['id_tiru'] ?></td>
                        <td align="center"><?php echo $r['nombre_tiru'] ?></td>
                        <td align="center"><?php echo $r['precio_tiru'] ?></td>
                        <td>
                            <center>

                                <a class="btn btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#exampleModal2" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                                                'id': '<?php echo $r['id_tiru'] ?? ''; ?>',
                                                'nombre': '<?php echo $r['nombre_tiru'] ?? ''; ?>',
                                                'precio': '<?php echo $r['precio_tiru'] ?? ''; ?>'
                                            });">
                                    <i class="fas fa-edit"> </i></a>


                                <a href="tipo_rutina/D_tipo_rutina.php?d=<?php echo $r['id_tiru'] ?>" class="btn btn-danger btn-circle " target="_parent">
                                    <i class="fas fa-trash"> </i></a>
                            </center>

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
<!-- MODAL REGISTRO DE TIPO DE RUTINA  -->
<div class="modal fade  " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">REGISTRO TIPO DE RUTINA</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <form action="tipo_rutina/R_tipo_rutina.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="Nombre-name" class="col-form-label" style="color: black;">Nombre:</label>
                                <input type="text" name="txtnombre" class="form-control" id="Nombre-name" required>
                            </div>
                        </div>




                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="Telefono-name" class="col-form-label" style="color: black;">PRECIO:</label>
                                <input type="text" name="txtprecio" class="form-control" maxlength="9" id="txtprecio-name" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary">REGISTRARSE</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<!-- EDITAR TIPO DE RUTINA  -->
<div class="modal fade  " id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR TIPO RUTINA</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <form action="tipo_rutina/U_tipo_rutina.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label" style="color: black;">CODIGO:</label>
                                <input type="text" name="txtcodigo" class="form-control" id="recipient_name" value="" disabled>
                                <input type="text" name="txtcod" class="form-control" id="recipient_name2" value="" hidden>
                            </div>
                            <div class="mb-3">
                                <label for="Nombre-name" class="col-form-label" style="color: black;">NOMBRE:</label>
                                <input type="text" name="txtnombre" class="form-control" id="nombre_name" required>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="Precio-name" class="col-form-label" style="color: black;">PRECIO:</label>
                                <input type="text" name="txtprecio" class="form-control" id="txtprecio">
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary">EDITAR</button>
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

        document.getElementById('recipient_name').value = dato.id;
        document.getElementById('recipient_name2').value = dato.id;
        document.getElementById('nombre_name').value = dato.nombre;
        document.getElementById('txtprecio').value = dato.precio;

    }


    let table = new DataTable('#table_tiporutina', {
        language: {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        },
        //para usar los botones   
        responsive: "true",
        dom: 'Bfrtilp',
        buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa-regular fa-file-excel"></i> ',
                titleAttr: 'Exportar a Excel',
                // className: 'btn btn-success'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa-regular fa-file-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                // className: 'btn btn-danger',
                orientation: 'landscape'
            },
            {
                extend: 'print',
                text: '<i class="fa-solid fa-print"></i>',
                titleAttr: 'Imprimir',
                // className: 'btn btn-info'
            },
        ]

    });
</script>