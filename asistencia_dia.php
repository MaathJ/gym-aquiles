<?php
include_once('auth.php');
include_once("inc/estructura/parte_superior.php");
include_once('config/dbconnect.php');
date_default_timezone_set('America/Lima');
?>
<link rel="stylesheet" src="style.css" href="assets/css/servicio/servicio.css">
<link rel="stylesheet" src="style.css" href="assets/css/datatables/datatables.css">
<link rel="stylesheet" src="style.css" href="assets/css/bootstrap/bootstrap.css">
<link rel="stylesheet" src="style.css" href="tabs-asistencia.css">
<div class="app-body-main-content">
    <div>
        <p>Pages<span> / Asistencias por Clase</span></p>
        <h3>Asistencias por Clase</h3>
    </div>
    <div class="main-content">
        <div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" id="regis-asis-hoy">Registro De Asistencias Hoy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="regis-asis-mes" href="#">Registro de Asistencias del Mes</a>
                </li>
            </ul>
        </div>
        <div id="collapseExample">

            <div class="col-md-12" style="background-color: white; padding: 1rem; border-radius: 1rem;">
                <div style="color: #f05941; font-weight: bolder; font-size: 2rem; text-align:center;">Asistencias Hoy</div>
                <table class="table table-striped" id="table_asistencia">

                    <thead style="color: #fff; background-color:#f05941;">
                        <tr align="center">
                            <th> CODIGO </th>
                            <th> NOMBRE </th>
                            <th> FECHA </th>
                            <th> PRECIO </th>
                            <th> RUTINA </th>
                            <th> OPCIONES</th>
                        </tr>
                    </thead>
                    <?php
                    include('config/dbconnect.php');


                    $fechaHoy = date('Y-m-d');

                    $sql = "SELECT * FROM asistencia_pago ap 
                                                    INNER JOIN tipo_rutina tr ON ap.id_tiru = tr.id_tiru 
                                                    WHERE DATE(ap.fech_asip) = DATE(NOW()) 
                                                    ORDER BY ap.id_asip DESC";
                    $f = mysqli_query($cn, $sql);

                    while ($r = mysqli_fetch_assoc($f)) {


                    ?>
                        <td align="center">
                            <?php echo $r['id_asip'] ?>
                        </td>
                        <td align="center">
                            <?php echo $r['nomb_asip'] ?>
                        </td>
                        <td align="center">
                            <?php echo $r['fech_asip'] ?>
                        </td>
                        <td align="center">
                            <?php echo $r['precio_tiru'] ?>
                        </td>
                        <td align="center">
                            <?php echo $r['nombre_tiru'] ?>
                        </td>
                        <td>
                            <center>

                                <a class="btn btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#exampleModal2" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                                                'id': '<?php echo $r['id_asip'] ?? ''; ?>',
                                                'nombre': '<?php echo $r['nomb_asip'] ?? ''; ?>',
                                                'fecha': '<?php echo $r['fech_asip'] ?? ''; ?>',
                                                'rutina': '<?php echo $r['nombre_tiru'] ?? ''; ?>'
                                            });">
                                    <i class="fas fa-edit"> </i></a>


                                <a href="asistencia_dia/D_asistencia_dia.php?d=<?php echo $r['id_asip'] ?>" class="btn btn-danger btn-circle " target="_parent">
                                    <i class="fas fa-trash"> </i></a>
                                <a class="btn btn-success btn-circle" data-bs-toggle="modal" data-bs-target="#pdfModal" data-bs-whatever="@mdo" target="_parent" onclick="pdf_cod(<?php echo $r['id_asip']; ?>, 'a_dia')">
                                    <i class="fa fa-ticket"></i>
                                </a>
                            </center>

                        </td>

                        </tr>
                    <?php
                    }
                    ?>



                </table>
            </div>
        </div>
        <div id="collapseExample2">
            <div class="col-md-12" style="background-color: white; padding: 1rem; border-radius: 1rem;">
                <div style="color: #f05941; font-weight: bolder; font-size: 2rem; text-align:center;">Asistencias Mensuales
                </div>
                <table class="table table-striped" id="table_asistencia2">

                    <thead style="color: #fff; background-color:#f05941;">
                        <tr align="center">
                            <th> CODIGO </th>
                            <th> NOMBRE </th>
                            <th> FECHA </th>
                            <th> PRECIO </th>
                            <th> RUTINA </th>
                            <th> OPCIONES</th>
                        </tr>
                    </thead>
                    <?php
                    include('config/dbconnect.php');

                    date_default_timezone_set('America/Lima');
                    $fechaHoy = date('Y-m-d');

                    $sql = "SELECT * FROM asistencia_pago ap 
                                                    INNER JOIN tipo_rutina tr ON ap.id_tiru = tr.id_tiru 
                                                    WHERE MONTH(ap.fech_asip) = MONTH('$fechaHoy') 
                                                    ORDER BY ap.id_asip DESC";

                    $f = mysqli_query($cn, $sql);
                    while ($r = mysqli_fetch_assoc($f)) {


                    ?>
                        <td align="center">
                            <?php echo $r['id_asip'] ?>
                        </td>
                        <td align="center">
                            <?php echo $r['nomb_asip'] ?>
                        </td>
                        <td align="center">
                            <?php echo $r['fech_asip'] ?>
                        </td>
                        <td align="center">
                            <?php echo $r['precio_tiru'] ?>
                        </td>
                        <td align="center">
                            <?php echo $r['nombre_tiru'] ?>
                        </td>
                        <td>
                            <center>

                                <a class="btn btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#exampleModal2" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                                                'id': '<?php echo $r['id_asip'] ?? ''; ?>',
                                                'nombre': '<?php echo $r['nomb_asip'] ?? ''; ?>',
                                                'fecha': '<?php echo $r['fech_asip'] ?? ''; ?>',
                                                'rutina': '<?php echo $r['nombre_tiru'] ?? ''; ?>'
                                            });">
                                    <i class="fas fa-edit"> </i></a>


                                <a href="asistencia_dia/D_asistencia_dia.php?d=<?php echo $r['id_asip'] ?>" class="btn btn-danger btn-circle " target="_parent">
                                    <i class="fas fa-trash"> </i></a>
                                <a class="btn btn-success btn-circle" data-bs-toggle="modal" data-bs-target="#pdfModal" data-bs-whatever="@mdo" target="_parent" onclick="pdf_cod(<?php echo $r['id_asip']; ?>, 'a_dia')">
                                    <i class="fa fa-ticket"></i>
                                </a>
                            </center>

                        </td>

                        </tr>
                    <?php
                    }
                    ?>



                </table>
            </div>
        </div>
    </div>

    <div class="modal fade  " id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">EDITAR REGISTRO ASISTENCIA POR DIA</h4>
                    <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <form action="asistencia_dia/U_asistencia_dia.php" method="post" enctype="multipart/form-data">
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
                                    <label for="Telefono-name" class="col-form-label" style="color: black;">FECHA:</label>
                                    <input type="datetime-local" name="txtfecha" class="form-control" maxlength="9" id="Fecha_name" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="Edad-name" class="col-form-label" style="color: black;">RUTINA:</label>

                                    <select name="txt_rutina" id="rutina_name" class="form-select" aria-label="Default select example">
                                        <?php
                                        include('conexion.php');
                                        $sql_2 = "select * from tipo_rutina";
                                        $f = mysqli_query($cn, $sql_2);
                                        while ($r = mysqli_fetch_assoc($f)) {
                                        ?>

                                            <option value="<?php echo $r['nombre_tiru'] ?>">
                                                <?php echo $r['nombre_tiru'] ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                    <input type="text" name="txtrutina" class="form-control" min="0" id="Rutina_name" hidden>

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
    include_once("inc/estructura/parte_inferior.php");
    //Trae el modal y el script
    include_once('ticket_extension.php');
    //--------------------------
    ?>
    <script src="assets/js/tabs-asistencia/tabs-asis.js"></script>
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