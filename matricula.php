<?php
include_once('auth.php');
include_once("inc/estructura/parte_superior.php");
include_once("matricula/U_estadoMatricula.php");
//Trae el modal y el script
include_once('ticket_extension.php');
//--------------------------
?>
<link rel="stylesheet" src="style.css" href="assets/css/servicio/servicio.css">
<link rel="stylesheet" src="style.css" href="assets/css/matricula/matricula.css">
<link rel="stylesheet" src="style.css" href="tabs-asistencia.css">

<!-- VERIFICAR LOS REGISTROS  -->

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

if (isset($_SESSION['deleted_matricula'])) {
    echo
    '<script>
setTimeout(() => {
    Swal.fire({
        title: "¡Éxito!",
        text: "' . $_SESSION['deleted_matricula'] . '",
        icon: "success"
    });
}, 500);
</script>';
    unset($_SESSION['deleted_matricula']);
}

if (isset($_SESSION['error_matricula'])) {
    echo
    '<script>
setTimeout(() => {
    Swal.fire({
        title: "¡Ups!",
        text: "' . $_SESSION['error_matricula'] . '",
        icon: "error"
    });
 }, 500);
</script>';
    unset($_SESSION['error_matricula']);
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
        <div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" id="regis-asis-hoy" href="#">Matriculas activas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="regis-asis-mes" href="#">Matriculas culminadas</a>
                </li>
            </ul>
        </div>

        <!-- //MATRICULAS ACTIVAS  -->
        <div id="collapseExample">
            <div class="col-md-12" style="background-color: white; padding: 1rem; border-radius: 1rem;">
                <table class="table table-sm" id="table_matricula" style="font-size: .8rem;">
                    <thead align="center" class="" style="color: #fff;">
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
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
                                WHERE ma.estado_ma != 'CULMINADO'
                                ORDER BY ma.estado_ma DESC, ma.id_ma DESC";
                        $f = mysqli_query($cn, $sqlm);

                        while ($r = mysqli_fetch_assoc($f)) {


                        ?>
                            <tr>
                                <td> <?php echo $r['id_ma']; ?></td>
                                <td>
                                    <img style="border-radius: 50%; align-self: center; height: 40px; width: 40px;" class="img-cliente" src="assets/images/cliente/<?php echo $r['dni_cli']; ?>.jpg" alt="">
                                <td style="text-transform: capitalize;"><?php echo  $r['nombre_cli'] ?></td>
                                <td style="text-transform: capitalize;"><?php echo $r['apellido_cli'] ?></td>
                                <td>
                                    <?php echo $r['dni_cli']; ?>
                                </td>
                                <td><?php echo $r['nombre_me'] . $r['nombre_se'] ?></td>
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
                                ?>
                                <td style="font-weight: 800;"><?php echo $diasRestantes . ' días' ?></td>
                                <td align="center">
                                    <button class="<?php echo ($r['estado_ma'] == 'ACTIVO') ? 'active-button' : 'waiting-button'; ?>">
                                        <?php echo $r['estado_ma'] ?>
                                    </button>
                                </td>

                                <td><?php echo $r['nombre_us'] ?></td>
                                <td><?php echo date('d-m-Y H:i:s', strtotime($r['fecharegistro_ma'])) ?></td>
                                <td><?php echo $r['desc_tp'] ?></td>
                                 
                                    <td style="display: flex; gap: 1rem; justify-content: center; align-items: center;">
                                        <!-- BOTON PARA EDITAR--> 
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
                                            <!-- BOTON PARA ADELANTOS--> 
                                        <a class="btn btn-sm btn-warning btn-circle" data-bs-toggle="modal" data-bs-target="#ModalAdelantos" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info_Adelanto({
                                                    'id_ma':'<?php echo $r['id_ma']; ?>',
                                                    'precio_ma':'<?php echo $r['precio_me']; ?>',
                                                    'fechainicio_ma':'<?php echo date('Y-m-d', strtotime($r['fechainicio_ma'])) ?? ''; ?>',
                                                    'fechafin_ma':'<?php echo date('Y-m-d', strtotime($r['fechafin_ma'])) ?? ''; ?>',
                                                    'estado_ma':'<?php echo $r['estado_ma'] ?>', 
                                                    'cliente_ma':'<?php echo $r['id_cli'] ?? ''; ?>', 
                                                    'membresia_ma':'<?php echo $r['id_me'] ?? ''; ?>',
                                                    'tp_ma':'<?php echo $r['id_tp'] ?? ''; ?>'
                                                    });">
                                        <i class="fa-solid fa-layer-group"></i></a>
                                    <!-- BOTON PARA ELIMINAR-->   
                                    <a href="matricula/D_matricula.php?cod=<?php echo $r['id_ma'] ?>" class="btn btn-sm btn-danger" target="_parent">
                                        <i class="fas fa-trash"> </i>
                                    </a>

                                    <!-- BOTON PARA TICKET-->
                                    <a class="btn btn-sm btn-success btn-circle" data-bs-toggle="modal" data-bs-target="#pdfModal" data-bs-whatever="@mdo" onclick="pdf_cod(<?php echo $r['id_ma']; ?>, 'mat')">
                                        <i class="fas fa-ticket"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
         <!-- MATRICULAS CULMINADAS  -->
        <div id="collapseExample2">
            <div class="col-md-12" style="background-color: white; padding: 1rem; border-radius: 1rem;">
                <table class="table table-sm" id="table_matricula_culm" style="font-size: .8rem;">
                    <thead align="center" class="" style="color: #fff">
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Foto</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
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
                                WHERE ma.estado_ma = 'CULMINADO'
                                ORDER BY ma.estado_ma DESC, ma.id_ma DESC";
                        $f = mysqli_query($cn, $sqlm);

                        while ($r = mysqli_fetch_assoc($f)) {


                        ?>
                            <tr>
                                <td>
                                    <img style="border-radius: 50%; align-self: center; height: 40px; width: 40px;" class="img-cliente" src="assets/images/cliente/<?php echo $r['dni_cli']; ?>.jpg" alt="">
                                <td style="text-transform: capitalize;"><?php echo  $r['nombre_cli'] ?></td>
                                <td style="text-transform: capitalize;"><?php echo $r['apellido_cli'] ?></td>
                                <td>
                                    <?php echo $r['dni_cli']; ?>
                                </td>
                                <td><?php echo $r['nombre_me'] . $r['nombre_se'] ?></td>
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
                                ?>
                                <td style="font-weight: 800;"><?php echo $diasRestantes . ' días' ?></td>
                                <td align="center">
                                    <button class="<?php echo ($r['estado_ma'] == 'ACTIVO') ? 'active-button' : 'inactive-button'; ?>">
                                        <?php echo $r['estado_ma'] ?>
                                    </button>
                                </td>

                                <td><?php echo $r['nombre_us'] ?></td>
                                <td><?php echo date('d-m-Y H:i:s', strtotime($r['fecharegistro_ma'])) ?></td>
                                <td><?php echo $r['desc_tp'] ?></td>

                                <td style="display: flex; gap: 1rem; justify-content: center; align-items: center;">
                                    <!-- <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalEditar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                                                    'id_ma':'<?php echo $r['id_ma']; ?>',
                                                    'precio_ma':'<?php echo $r['precio_me']; ?>',
                                                    'fechainicio_ma':'<?php echo date('Y-m-d', strtotime($r['fechainicio_ma'])) ?? ''; ?>',
                                                    'fechafin_ma':'<?php echo date('Y-m-d', strtotime($r['fechafin_ma'])) ?? ''; ?>',
                                                    'estado_ma':'<?php echo $r['estado_ma'] ?>', 
                                                    'cliente_ma':'<?php echo $r['id_cli'] ?? ''; ?>', 
                                                    'membresia_ma':'<?php echo $r['id_me'] ?? ''; ?>',
                                                    'tp_ma':'<?php echo $r['id_tp'] ?? ''; ?>'
                                                    });">
                                        <i class="fas fa-edit"> </i></a> -->

                                    <a href="matricula/D_matricula.php?cod=<?php echo $r['id_ma'] ?>" class="btn btn-sm btn-danger" target="_parent">
                                        <i class="fas fa-trash"> </i>
                                    </a>

                                    <!-- BOTON PARA TICKET-->
                                    <a class="btn btn-sm btn-success btn-circle" data-bs-toggle="modal" data-bs-target="#pdfModal" data-bs-whatever="@mdo" onclick="pdf_cod(<?php echo $r['id_ma']; ?>, 'mat')">
                                        <i class="fas fa-ticket"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
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


                <form action="matricula/R_matricula.php" method="post">
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
                                <select class="form-select form-select-sm mb-3" name="u_lstmembresia" id="membresia_u" onchange="actualizarPrecio_U()" required>

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
                                <input type="date" name="u_fechadesde" class="form-control" id="fechaini_u" oninput="agregar_U()" required>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="col-form-label" style="color: black;">Estado:</label>
                                <select class="form-select form-select-sm mb-3" name="u_lstestado" id="estado_u" required>
                                    <option value="" disabled selected>Selecciona un estado</option>

                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="CULMINADO">CULMINADO</option>

                                </select>

                            </div>

                            <!-- Medio de pago -->
                            <div class="mb-3">
                                <label for="tipo_pago_u" class="col-form-label" style="color: black;">Tipo de pago:</label>
                                <select class="form-select form-select-sm mb-3" name="u_lst_tp" id="tipo_pago_u" onchange="" required>

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

                                <input type="text" name="u_precio" class="form-control" id="precio_u" disabled>


                            </div>

                            <div class="mb-3">
                                <label for="datehasta" class="col-form-label" style="color: black;">Hasta:</label>

                                <input type="date" class="form-control" id="fechafin_u" disabled>
                                <input type="date" name="u_fechahasta" class="form-control" id="fechafin_u2" required hidden>


                            </div>


                            <div class="mb-3">
                                <label for="cliente" class="col-form-label" style="color: black;">Cliente:</label>
                                <select class="form-select form-select-sm mb-3" name="u_lstcliente" id="cliente_u" required>

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


<!-- MODAL PARA ADELANTOS  -->
<div class="modal fade  " id="ModalAdelantos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #01C408; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">ADELANTOS MATRICULA:</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="matricula/A_matricula.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <input type="text" name="id_a" id="id_a" hidden>
                                <label for="membresia" class="col-form-label" style="color: black;">Membresia:</label>
                                <select class="form-select form-select-sm mb-3" name="a_lstmembresia" id="membresia_a" onchange="actualizarPrecio_A()" required>

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
                                <input type="date" name="a_fechadesde" class="form-control" id="fechaini_a" oninput="agregar_A()" required>
                            </div>
                            <div class="mb-3">
                               

                            </div>

                            <!-- Medio de pago -->
                            <div class="mb-3">
                                <label for="tipo_pago_u" class="col-form-label" style="color: black;">Tipo de pago:</label>
                                <select class="form-select form-select-sm mb-3" name="a_lst_tp" id="tipo_pago_a" onchange="" required>

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

                                <input type="text" name="a_precio" class="form-control" id="precio_a" disabled>


                            </div>

                            <div class="mb-3">
                                <label for="datehasta" class="col-form-label" style="color: black;">Hasta:</label>

                                <input type="date" class="form-control" id="fechafin_a" disabled>
                                <input type="date" name="a_fechahasta" class="form-control" id="fechafin_a2" required hidden>


                            </div>


                            <div class="mb-3">
                                <label for="cliente" class="col-form-label" style="color: black;">Cliente:</label>
                                <input type="text" id="cliente_a2" name="a_lstcliente" hidden>
                                <select class="form-select form-select-sm mb-3" id="cliente_a" required disabled>

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
                        <button type="submit" class="btn btn-primary" id="editar">ADELANTAR</button>
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
<script src="assets/js/tabs-asistencia/tabs-asis.js"></script>


<script>
    var tiempo = 0;
    // FUNCIONES PARA CREATE 
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

    // FUNCIONES PARA EDITAR 
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

    function agregar_U() {
        // Obtener el valor del input de fecha de inicio
        var fechaInput = document.getElementById('fechaini_u').value;

        // Crear un objeto de fecha con la fecha ingresada
        var fecha = new Date(fechaInput);

        // Obtener la duración de la membresía seleccionada
        var opcionSeleccionada = document.getElementById("membresia_u").options[document.getElementById("membresia_u").selectedIndex];
        var tiempoMembresia = parseInt(opcionSeleccionada.getAttribute("data-time"));

        

        // Agregar la duración de la membresía (meses) a la fecha de inicio
        fecha.setMonth(fecha.getMonth() + tiempoMembresia);

        fecha.setDate(fecha.getDate());
        fecha.setDate(fecha.getDate() - 1); // Retroceder un día para obtener el último día del mes

        // Formatear la fecha resultante para el input de tipo date (YYYY-MM-DD)
        var resultado2 = fecha.toISOString().split('T')[0];

        // Mostrar la fecha resultante en el input correspondiente
        
        document.getElementById('fechafin_u').value = resultado2;
        document.getElementById('fechafin_u2').value = resultado2;
    }

     // FUNCIONES PARA ADELANTOS 
       function actualizarPrecio_A() {
        // Obtén la opción seleccionada
        var opcionSeleccionada = document.getElementById("membresia_a");
        var precioSeleccionado = opcionSeleccionada.options[opcionSeleccionada.selectedIndex].text;

        // Extrae el precio del texto de la opción seleccionada
        var precio = precioSeleccionado.split('S/')[1].trim();

        // Actualiza el valor del campo de entrada precio
        document.getElementById("precio_a").value = precio;

        //Obtengo el tiempo del select
        var select = document.getElementById("membresia_a");

        // Obtener la opción seleccionada
        var opcionSeleccionada = select.options[select.selectedIndex];

        // Obtener el dato personalizado usando el atributo data-*
        tiempo = parseInt(opcionSeleccionada.getAttribute("data-time"));

        agregar_A();
    }

    function agregar_A() {
        // Obtener el valor del input de fecha de inicio
        var fechaInput = document.getElementById('fechaini_a').value;

        // Crear un objeto de fecha con la fecha ingresada
        var fecha = new Date(fechaInput);

        // Obtener la duración de la membresía seleccionada
        var opcionSeleccionada = document.getElementById("membresia_a").options[document.getElementById("membresia_a").selectedIndex];
        var tiempoMembresia = parseInt(opcionSeleccionada.getAttribute("data-time"));

        

        // Agregar la duración de la membresía (meses) a la fecha de inicio
        fecha.setMonth(fecha.getMonth() + tiempoMembresia);

        fecha.setDate(fecha.getDate());
        fecha.setDate(fecha.getDate() - 1); // Retroceder un día para obtener el último día del mes

        // Formatear la fecha resultante para el input de tipo date (YYYY-MM-DD)
        var resultado2 = fecha.toISOString().split('T')[0];

        // Mostrar la fecha resultante en el input correspondiente
        
        document.getElementById('fechafin_a').value = resultado2;
        document.getElementById('fechafin_a2').value = resultado2;
    }



</script>

<script>
    
    // FUNCION PARA CARGAR EDITAR
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
    // FUNCION PARA CARGAR EDITAR
    function cargar_info_Adelanto(dato) {
    document.getElementById('id_a').value = dato.id_ma;
    document.getElementById('precio_a').value = dato.precio_ma;

    document.getElementById('fechaini_a').value = dato.fechafin_ma;

    // Esperar a que se cargue correctamente fechaini_a antes de establecer la fecha mínima en fechaini_b
    setTimeout(function() {
        var fechaini_a = document.getElementById('fechaini_a').value;

        // Establecer la fecha mínima en fechaini_a
        document.getElementById('fechaini_a').min = fechaini_a;
    }, 100); // Esperar 100 milisegundos (ajusta el tiempo según sea necesario)

    document.getElementById('cliente_a').value = dato.cliente_ma;
    document.getElementById('cliente_a2').value = dato.cliente_ma;
    // document.getElementById('membresia_a').value = dato.membresia_ma;
    document.getElementById('tipo_pago_a').value = dato.tp_ma;
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
    let table2 = new DataTable('#table_matricula_culm', {
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