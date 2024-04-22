<?php
include_once("inc/estructura/parte_superior.php");
include_once('config/dbconnect.php');
?>
<link rel="stylesheet" src="style.css" href="assets/css/rutina/rutina.css">
<link rel="stylesheet" src="style.css" href="assets/css/datatables/datatables.css">
<link rel="stylesheet" src="style.css" href="assets/css/bootstrap/bootstrap.css">
<div class="app-body-main-content">
    <div>
        <p>Pages<span> / Rutina</span></p>
        <h3>RUTINA</h3>
    </div>
    <div class="main-content">
        <div>
            <button class="rutina" data-bs-toggle="modal" data-bs-target="#R_servicio" data-bs-whatever="@mdo">
                Nuevo Rutina
            </button>
        </div>
        <div class="col-md-12">
            <table class="table table-striped" id="table_tiporutina">

                <thead align="center" class="" style="color: #fff; background-color:#f05941;">
                    <tr>
                        <th class="text-center"> CODIGO </th>
                        <th class="text-center"> NOMBRE </th>
                        <th class="text-center"> PRECIO </th>
                        <th class="text-center"> OPCIONES</th>
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

                                <a class="btn btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#U_servicio" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                                                'id': '<?php echo $r['id_tiru'] ?? ''; ?>',
                                                'nombre': '<?php echo $r['nombre_tiru'] ?? ''; ?>',
                                                'precio': '<?php echo $r['precio_tiru'] ?? ''; ?>'
                                            });">
                                    <i class="fas fa-edit"> </i></a>


                                <a href="tipo_rutina/D_tipo_rutina.php?codigo=<?php echo $r['id_tiru'] ?>" class="btn btn-danger btn-circle " target="_parent">
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

    <!-- MODAL PARA REGISTRO  -->
    <div class="modal fade" id="R_servicio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #F39C12; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">REGISTRAR NUEVA RUTINA</h4>
                    <button type="button" class="btn-close" style="background-color: #ffffff;" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="tipo_rutina/R_tipo_rutina.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label" style="color: black;">Nombre:</label>
                                    <input type="text" name="txtnombre" class="form-control" id="recipient-name" required>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label" style="color: black;">Precio:</label>
                                    <input type="number" name="txtprecio" class="form-control" id="recipient-name" required>
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

     <!-- MODAL PARA ACTUALIZAR  -->
     <div class="modal fade" id="U_servicio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #F39C12; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">ACTUALIZAR  RUTINA</h4>
                    <button type="button" class="btn-close" style="background-color: #ffffff;" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="tipo_rutina/U_tipo_rutina.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label" style="color: black;">Nombre:</label>
                                    <input type="text" name="U_txtnombre" class="form-control" id="u_nombre" required>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label" style="color: black;">Precio:</label>
                                    <input type="number" name="U_txtprecio" class="form-control" id="u_precio" required>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="u_cod" name="txtcod">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                            <button type="submit" class="btn btn-primary">GUARDAR</button>
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
           
            document.getElementById('u_cod').value = dato.id;
            document.getElementById('u_nombre').value = dato.nombre;
            document.getElementById('u_precio').value = dato.precio;
          
        

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