<?php
include_once('auth.php');
include_once("inc/estructura/parte_superior.php");
//Trae el modal y el script
include_once('ticket_extension.php');
//--------------------------
?>
<link rel="stylesheet" src="style.css" href="assets/css/matricula/matricula.css">
<div class="app-body-main-content">
    <div>
        <p>Pages<span> / Matricula</span></p>
        <h3>Matricula</h3>
    </div>
    <div class="main-content">
        <div>
            <button class="matricula" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                Nueva Matricula
            </button>
        </div>
        <div class="col-md-12">
            <table class="table table-striped" id="table_matricula">
                <thead align="center" class="" style="color: #fff; background-color:#f05941;">
                    <tr>
                        <th>ID</th>
                        <th>Foto</th>
                        <th>Cliente</th>
                        <th>DNI</th>
                        <th>Membresia-Servicio</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Vencimiento</th>
                        <th>Dias Restantes</th>
                        <th>Estado</th>
                        <th>Empleado</th>
                        <th>Fecha Registro</th>
                        <th>Medio de pago</th>
                        <th>Opciones</th>
                    </tr>

                </thead>
                <tbody>
                    <?php
                    include_once("config/dbconnect.php");
                    $sqlm = "SELECT ma.*, me.*, se.*, cli.*, us.*, tp.*
                                            FROM matricula as ma
                                            INNER JOIN membresia me ON ma.id_me = me.id_me
                                            INNER JOIN servicio se ON me.id_se = se.id_se
                                            INNER JOIN cliente cli ON ma.id_cli = cli.id_cli
                                            INNER JOIN usuario us ON ma.id_us = us.id_us
                                            INNER JOIN tipo_pago tp ON ma.id_tp = tp.id_tp
                                            ORDER BY ma.estado_ma DESC, ma.id_ma DESC";
                    $f = mysqli_query($cn, $sqlm);

                    while ($r = mysqli_fetch_assoc($f)) {


                    ?>

                        <tr>
                            <td><?php echo $r['id_ma'] ?></td>
                            <td>
                                <img class="img-cliente" src="assets/images/cliente/<?php echo $r['dni_cli']; ?>.jpg" alt="">
                            <td style="display: flex; flex-direction: row; text-transform: capitalize; text-wrap: wrap; text-align: center;"><?php echo $r['apellido_cli'] . ', ' . $r['nombre_cli'] ?></td>
                            <td>
                                <?php echo $r['dni_cli']; ?>

                            </td>


                            <td><?php echo $r['nombre_me'] . '<p class="text-membre">' . $r['nombre_se'] . '</p>' ?></td>

                            <td><?php echo date('d-m-Y', strtotime($r['fechainicio_ma'])) ?></td>

                            <?php
                            $fechaFin = new DateTime($r['fechafin_ma']);
                            $fechaFin->modify('-1 day');
                            ?>

                            <td><?php echo $fechaFin->format('d-m-Y'); ?></td>

                            <?php
                            date_default_timezone_set('America/Lima');
                            $fechaHoy = new DateTime();
                            $fechaFin = new DateTime($r['fechafin_ma']);
                            $diferencia = $fechaHoy->diff($fechaFin);
                            $diasRestantes = $diferencia->days;

                            $estado = $r['estado_ma'];
                            $colorLetra = '';

                            // Ajustar a cero si la diferencia es menor a 0 días
                            $diasRestantes = max($diasRestantes, 0);

                            // Ajustar a cero si la fecha actual ha superado la fecha de finalización
                            if ($fechaHoy > $fechaFin) {
                                $diasRestantes = 0;
                                $estado = 'CULMINADO';

                                // Actualizar el estado en la base de datos
                                $id_ma = $r['id_ma'];  // Asegúrate de tener el identificador adecuado para tu caso
                                $sqlUpdate = "UPDATE matricula SET estado_ma = 'CULMINADO' WHERE id_ma = $id_ma";
                                mysqli_query($cn, $sqlUpdate);
                            } elseif ($r['estado_ma'] == 'ACTIVO') {
                                // Tu lógica para el estado ACTIVO
                            }
                            ?>

                            <td style="font-weight: 800;"><?php echo $diasRestantes . ' días' ?></td>



                            <td class="<?php echo ($r['estado_ma'] == 'ACTIVO') ? 'tdactivo' : 'tdculminado'; ?>">
                                <p><?php echo $estado ?></p>
                            </td>

                            <td><?php echo $r['nombre_us'] ?></td>
                            <td><?php echo date('d-m-Y H:i:s', strtotime($r['fecharegistro_ma'])) ?></td>
                            <td><?php echo $r['desc_tp'] ?></td>

                            <td style="display: flex; gap: 1rem; justify-content: center; align-items: center;">



                                <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalEditar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                                                'id_ma':'<?php echo $r['id_ma']; ?>',
                                                'precio_ma':'<?php echo $r['precio_me']; ?>',
                                                'fechainicio_ma':'<?php echo date('Y-m-d', strtotime($r['fechainicio_ma'])) ?? ''; ?>',
                                                'fechafin_ma':'<?php echo date('Y-m-d', strtotime($r['fechafin_ma'])) ?? ''; ?>',
                                                'estado_ma':'<?php echo $r['estado_ma'] ?>', 
                                                'cliente_ma':'<?php echo $r['id_cli'] ?? ''; ?>', 
                                                'membresia_ma':'<?php echo $r['id_me'] ?? ''; ?>',
                                                'tp_ma':'<?php echo $r['id_tp'] ?? ''; ?>'
                                                });">
                                    <i class="fas fa-edit"> </i></a>


                                <a href="matricula/D_matricula.php?cod=<?php echo $r['id_ma'] ?>" class="btn btn-sm btn-danger" target="_parent"><i class="fas fa-trash"> </i></a>

                                <!-- BOTON PARA TICKET-->
                                <a class="btn btn-sm  btn-circle text-white" data-bs-toggle="modal" data-bs-target="#pdfModal" data-bs-whatever="@mdo" onclick="pdf_cod(<?php echo $r['id_ma']; ?>, 'mat')">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                </tbody>


            </table>

        </div>
    </div>
</div>

<!-- MODAL PARA REGISTRO MATRICULA  -->
<div class="modal fade  " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">REGISTRO MATRICULA:</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <form action="matricula.php" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="membresia" class="col-form-label" style="color: black;">Membresia:</label>
                                <select class="form-select form-select-sm mb-3" name="lstmembresia" id="membresia" onchange="actualizarPrecio()" required>

                                    <option value="" disabled selected>Selecciona una membresia</option>

                                    <?php
                                    $sql = "SELECT * FROM membresia Where estado_me='ACTIVO'";
                                    $f = mysqli_query($cn, $sql);

                                    while ($r = mysqli_fetch_assoc($f)) {


                                    ?>
                                        <option value="<?php echo $r['id_me'] ?>" data-time="<?php echo $r['duracion_me']; ?>"><?php echo $r['nombre_me'] . '- S/' . $r['precio_me'] ?></option>

                                    <?php
                                    }

                                    ?>


                                </select>

                            </div>
                            <div class="mb-3">
                                <label for="datedesde" class="col-form-label" style="color: black;">Desde:</label>
                                <input type="date" name="fechadesde" class="form-control" id="fechaInput" oninput="agregar()" required>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="col-form-label" style="color: black;">Estado:</label>
                                <select class="form-select form-select-sm mb-3" name="lstestado" id="estado" required>

                                    <option value="" disabled>Selecciona una estado</option>
                                    <option value="ACTIVO" selected>ACTIVO</option>


                                </select>

                            </div>

                            <!-- Medio de pago -->
                            <div class="mb-3">
                                <label for="tipo_pago" class="col-form-label" style="color: black;">Tipo de pago:</label>
                                <select class="form-select form-select-sm mb-3" name="lst_tp" id="tipo_pago" onchange="" required>

                                    <option value="" disabled selected>Selecciona un tipo de pago</option>

                                    <?php
                                    $sql_tp = "SELECT * FROM tipo_pago";
                                    $f_tp = mysqli_query($cn, $sql_tp);

                                    while ($r_tp = mysqli_fetch_assoc($f_tp)) {


                                    ?>
                                        <option value="<?php echo $r_tp['id_tp'] ?>"><?php echo $r_tp['desc_tp']; ?></option>

                                    <?php
                                    }

                                    ?>


                                </select>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="precio" class="col-form-label" style="color: black;">Precio:</label>

                                <input type="text" name="precio" class="form-control" id="precio" disabled>


                            </div>

                            <div class="mb-3">
                                <label for="datehasta" class="col-form-label" style="color: black;">Hasta:</label>

                                <input type="date" name="fechahasta" class="form-control" id="resultadoInput" readonly required>


                            </div>


                            <div class="mb-3">
                                <label for="cliente" class="col-form-label" style="color: black;">Cliente:</label>
                                <select class="form-select form-select-sm mb-3" name="lstcliente" id="cliente" required>

                                    <option value="" disabled selected>Selecciona un cliente</option>

                                    <?php
                                    // include('config/dbconnect.php');
                                    $sql = "SELECT *
                                    FROM cliente cli
                                    WHERE cli.estado_cli = 'ACTIVO'
                                    AND NOT EXISTS (
                                        SELECT 1
                                        FROM matricula ma
                                        WHERE cli.id_cli = ma.id_cli AND ma.estado_ma = 'ACTIVO'
                                    )
                                    ORDER BY cli.apellido_cli DESC;";
                                    $f = mysqli_query($cn, $sql);

                                    while ($r = mysqli_fetch_assoc($f)) {


                                    ?>
                                        <option value="<?php echo $r['id_cli'] ?>"><?php echo $r['apellido_cli'] . ',' . $r['nombre_cli'] ?></option>

                                    <?php
                                    }

                                    ?>


                                </select>

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


<!-- MODAL PARA Editar MATRICULA  -->
<div class="modal fade  " id="ModalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR MATRICULA:</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="matricula/U_matricula.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <input type="text" name="id_u" id="id_u" hidden>
                                <label for="membresia" class="col-form-label" style="color: black;">Membresia:</label>
                                <select class="form-select form-select-sm mb-3" name="lstmembresia" id="membresia_u" onchange="actualizarPrecio_U()" required>

                                    <option value="" disabled selected>Selecciona una membresia</option>

                                    <?php
                                    $sql = "SELECT * FROM membresia m INNER JOIN servicio s ON m.id_se=s.id_se Where m.estado_me='ACTIVO'";
                                    $f = mysqli_query($cn, $sql);

                                    while ($r = mysqli_fetch_assoc($f)) {
                                    ?>
                                        <option value="<?php echo $r['id_me'] ?>" data-time="<?php echo $r['duracion_me'];  ?>">
                                            <?php echo $r['nombre_me'] . ' - ' . $r['nombre_se'] . ' - S/' . $r['precio_me'] ?></option>

                                    <?php } ?>

                                </select>

                            </div>
                            <div class="mb-3">
                                <label for="datedesde" class="col-form-label" style="color: black;">Desde:</label>
                                <input type="date" name="fechadesde" class="form-control" id="fechaini_u" oninput="agregar_U()" required>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="col-form-label" style="color: black;">Estado:</label>
                                <select class="form-select form-select-sm mb-3" name="lstestado" id="estado_u" required>
                                    <option value="" disabled selected>Selecciona un estado</option>

                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="CULMINADO">CULMINADO</option>

                                </select>

                            </div>

                            <!-- Medio de pago -->
                            <div class="mb-3">
                                <label for="tipo_pago_u" class="col-form-label" style="color: black;">Tipo de pago:</label>
                                <select class="form-select form-select-sm mb-3" name="lst_tp" id="tipo_pago_u" onchange="" required>

                                    <option value="" disabled selected>Selecciona un tipo de pago</option>

                                    <?php
                                    $sql_tp = "SELECT * FROM tipo_pago";
                                    $f_tp = mysqli_query($cn, $sql_tp);

                                    while ($r_tp = mysqli_fetch_assoc($f_tp)) {


                                    ?>
                                        <option value="<?php echo $r_tp['id_tp'] ?>"><?php echo $r_tp['desc_tp']; ?></option>

                                    <?php
                                    }

                                    ?>


                                </select>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="precio" class="col-form-label" style="color: black;">Precio:</label>

                                <input type="text" name="precio" class="form-control" id="precio_u" disabled>


                            </div>

                            <div class="mb-3">
                                <label for="datehasta" class="col-form-label" style="color: black;">Hasta:</label>

                                <input type="date" class="form-control" id="fechafin_u" disabled>
                                <input type="date" name="fechahasta" class="form-control" id="fechafin_u2" required hidden>


                            </div>


                            <div class="mb-3">
                                <label for="cliente" class="col-form-label" style="color: black;">Cliente:</label>
                                <select class="form-select form-select-sm mb-3" name="lstcliente" id="cliente_u" required>

                                    <option value="" disabled selected>Selecciona un cliente</option>

                                    <?php
                                    $sql = "SELECT * FROM cliente where estado_cli = 'ACTIVO' ORDER BY apellido_cli DESC";
                                    $f = mysqli_query($cn, $sql);

                                    while ($r = mysqli_fetch_assoc($f)) {
                                    ?>
                                        <option value="<?php echo $r['id_cli'] ?>"><?php echo $r['apellido_cli'] . ',' . $r['nombre_cli'] ?></option>
                                    <?php } ?>
                                </select>

                            </div>



                        </div>

                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="editar">Editar</button>
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

<?php

if (
    isset($_GET['lstmembresia']) &&
    isset($_GET['fechadesde']) &&
    isset($_GET['lstestado']) &&
    isset($_GET['lstcliente']) &&
    isset($_GET['fechahasta'])
) {
    $fechadesde = $_GET['fechadesde'];
    $fechahasta = $_GET['fechahasta'];
    $estado = $_GET['lstestado'];
    $cliente = $_GET['lstcliente'];
    $membresia = $_GET['lstmembresia'];
    $usuario = $_SESSION["usuario"];


    $sql = "INSERT INTO matricula (fechainicio_ma, fechafin_ma, estado_ma, id_cli, id_me, id_us)
   VALUES('$fechadesde', '$fechahasta', '$estado', '$cliente', $membresia, $usuario)";
    $f = mysqli_query($cn, $sql);

    if ($f) {
        echo '<script>window.location.href = "matricula.php";</script>';
    } else {
        echo 'Fallo';
    }
}
?>


<script>
    var tiempo = 0;

    function actualizarPrecio() {
        // Obtén la opción seleccionada
        var opcionSeleccionada = document.getElementById("membresia");
        var precioSeleccionado = opcionSeleccionada.options[opcionSeleccionada.selectedIndex].text;

        // Extrae el precio del texto de la opción seleccionada
        var precio = precioSeleccionado.split('S/')[1].trim();

        // Actualiza el valor del campo de entrada precio
        document.getElementById("precio").value = precio;

        //Obtengo el tiempo del select
        var select = document.getElementById("membresia");


        // Obtener la opción seleccionada
        var opcionSeleccionada = select.options[select.selectedIndex];

        // Obtener el dato personalizado usando el atributo data-*
        tiempo = parseInt(opcionSeleccionada.getAttribute("data-time"));

        agregar();
    }

    function actualizarPrecio_U() {
        // Obtén la opción seleccionada
        var opcionSeleccionada = document.getElementById("membresia_u");
        var precioSeleccionado = opcionSeleccionada.options[opcionSeleccionada.selectedIndex].text;

        // Extrae el precio del texto de la opción seleccionada
        var precio = precioSeleccionado.split('S/')[1].trim();

        // Actualiza el valor del campo de entrada precio
        document.getElementById("precio_u").value = precio;

        //Obtengo el tiempo del select
        var select = document.getElementById("membresia_u");

        // Obtener la opción seleccionada
        var opcionSeleccionada = select.options[select.selectedIndex];

        // Obtener el dato personalizado usando el atributo data-*
        tiempo = parseInt(opcionSeleccionada.getAttribute("data-time"));

        agregar_U();
    }

    function agregar() {
        // Obtener el valor del input de fecha y membresia
        var fechaInput = document.getElementById('fechaInput').value;

        // Crear un objeto de fecha con la fecha ingresada
        var fecha = new Date(fechaInput);

        // Agregar el tiempo a la fecha
        fecha.setMonth(fecha.getMonth() + tiempo);
        fecha.setDate(fecha.getDate());

        // Formatear la fecha resultante (opcional)
        var resultado = fecha.toLocaleDateString();

        // Formatear la fecha resultante para el input de tipo date
        var resultado = fecha.toISOString().split('T')[0];

        // Mostrar la fecha resultante en algún lugar de la página
        document.getElementById('resultadoInput').value = resultado;
    }

    function agregar_U() {
        // Obtener el valor del input de fecha y membresia
        var fechaInput = document.getElementById('fechaini_u').value;

        // Crear un objeto de fecha con la fecha ingresada
        var fecha = new Date(fechaInput);

        // Agregar el tiempo a la fecha y restar un dia
        fecha.setMonth(fecha.getMonth() + tiempo);

        fecha.setDate(fecha.getDate());
        // fecha.setDate(fecha.getDate() - 1);

        // Formatear la fecha resultante (opcional)
        var resultado = fecha.toLocaleDateString();

        // Formatear la fecha resultante para el input de tipo date
        var resultado = fecha.toISOString().split('T')[0];
        var resultado2 = resultado;

        // Mostrar la fecha resultante en algún lugar de la página
        document.getElementById('fechafin_u').value = resultado;
        document.getElementById('fechafin_u2').value = resultado2;
    }
</script>

<script>
    function cargar_info(dato) {
        document.getElementById('id_u').value = dato.id_ma;
        document.getElementById('precio_u').value = dato.precio_ma;
        document.getElementById('fechaini_u').value = dato.fechainicio_ma;
        document.getElementById('fechafin_u').value = dato.fechafin_ma;
        document.getElementById('fechafin_u2').value = dato.fechafin_ma;
        document.getElementById('estado_u').value = dato.estado_ma;
        document.getElementById('cliente_u').value = dato.cliente_ma;
        document.getElementById('membresia_u').value = dato.membresia_ma;
        document.getElementById('tipo_pago_u').value = dato.tp_ma;
    }
</script>


<script>
    let table = new DataTable('#table_matricula', {
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
                text: '<i class="fa-regular fa-file-excel"></i>',
                titleAttr: 'Exportar a Excel',
                // className: 'btn btn-success'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa-regular fa-file-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                // className: 'btn btn-danger',
                // orientation: 'landscape' 
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

<style>
    .tdactivo {
        display: grid;
        place-items: center;
    }

    .tdculminado {
        display: grid;
        place-items: center;
    }

    .tdactivo p {
        background: #4D9C5A;
        border-radius: 15px;
        font-weight: 600;
        color: white;
        padding: 3px 15px;

    }

    .tdculminado p {
        background: red;
        border-radius: 15px;
        font-weight: 600;
        color: white;
        padding: 7px;
    }

    .img-cliente {
        width: 50px;

    }

    .img-cliente img {
        width: 40px;
        height: 40px;
        border-radius: 1000%;
        -o-object-fit: cover;
        object-fit: cover;
    }
</style>