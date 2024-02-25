<?php
include_once('auth.php');
include_once('./src/components/parte_superior.php');
?>
<?php
include('./config/conexion.php');

$sqlma = "SELECT 
    DATEDIFF(bo.ffin_bo, CURRENT_DATE) AS dias_restantes,
    SUM(CASE WHEN bo.estadodeu_bo = 'DEUDA' AND bo.estadodur_bo = 'ACTIVO' THEN bo.deuda_bo ELSE 0 END) AS total_deudas,
    SUM(CASE WHEN bo.mes_bo IS NOT NULL THEN bo.mes_bo ELSE 0 END) AS total_meses,
    ma.*, al.*, ci.*, us.*, de.nombre_de, de.monto_de, ma.observacion_ma, pe.*
FROM 
    matricula ma
INNER JOIN  
    alumno al ON ma.id_al = al.id_al
INNER JOIN 
    ciclo ci ON ma.id_ci = ci.id_ci
INNER JOIN 
    periodo pe ON ci.id_pe = pe.id_pe
INNER JOIN 
    usuario us ON ma.id_us = us.id_us
LEFT JOIN  
    descuento de ON ma.id_de = de.id_de
LEFT JOIN 
    boleta bo ON ma.id_ma = bo.id_ma 
GROUP BY 
    ma.id_ma";



?>
<!-- Asegúrate de incluir jQuery y jQuery UI -->

<link rel="stylesheet" href="./src/assets/css/matricula/matricula.css">




<div class="container-page">
    <div>
        <p>Zeus<span> / Matrícula</span></p>
        <h3>Matrícula</h3>
    </div>

    <button class="turno btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalMatriculaRegistro" data-bs-whatever="@mdo" style="cursor: pointer;">Registrar</button>

    <br>
    <div class="container-table" style="background-color: #fff; overflow:hidden">
        <div class="col-md-12" style="box-sizing: border-box;">
            <table class="table table-responsive-sm" id="table_matricula" style="width:100%; box-sizing: border-box; overflow:hidden">
                <thead align="center" class="" style="color: #fff; background-color:#010133; height:52px; max-height:100%;">
                    <tr>
                        <!-- <th class="text-center">ID</th> -->

                        <th class="text-center">ID</th>
                        <th class="text-center">Apellidos</th>
                        <th class="text-center">Nombres</th>
                        <th class="text-center">Ciclo</th>
                        <th class="text-center">Mensualidad</th>
                        <th class="text-center">Meses</th>
                        <th class="text-center">Boletas</th>
                        <th class="text-center">Días Restantes</th>
                        <th class="text-center">Deuda</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Operario</th>
                        <th class="text-center">Más Info.</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $fmat = mysqli_query($cn, $sqlma);
                    while ($rma = mysqli_fetch_assoc($fmat)) {
                        $id = $rma['id_ma'];
                        $inicio = $rma['fini_ci'];
                        $final = $rma['ffin_ci'];
                        $dias_restantes = $rma['dias_restantes'];
                    ?>
                        <tr>
                            <td>
                                <?php echo $rma['id_al'] ?>
                            </td>
                            <td style="font-weight: 500;">
                                <?php echo $rma['apellido_al'] ?>
                            </td>
                            <td>
                                <?php echo $rma['nombre_al'] ?>
                            </td>
                            <td align="center">
                                <?php echo $rma['nombre_pe'] . ' ' . $rma['nombre_ci'] ?>
                            </td>
                            <td align="center">
                                <?php echo $rma['mensualidad_ma'] ?>
                            </td>
                            <td align="center">
                                <?php echo $rma['total_meses'] ?>
                            </td>
                            <td align="center">

                                <a class="btn btn-lx " style="background-color: #4385F5; color: white; text-decoration: none;" href="boleta.php?id=<?php echo $rma['id_ma']; ?>"><i class="fa-solid fa-file-invoice"></i></a>

                            </td>

                            <td align="center">

                                <?php
                                if ($dias_restantes !== null && $dias_restantes !== false && $dias_restantes !== 0) {
                                    echo $dias_restantes . ' Días';
                                } else {
                                    echo '0 Dias';
                                }
                                ?>

                            </td>
                            <td align="center" style="font-weight: 700; color: <?php echo ($rma['total_deudas'] > 0) ? 'red' : 'black'; ?> ">
                                <?php echo 'S/' . $rma['total_deudas']; ?>
                            </td>

                            <td>
                                <?php $estado = $rma['estado_ma'];
                                $button = '<button class= "' . ($estado === "ACTIVO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button';
                                echo $button;
                                ?>
                                |
                            </td>
                            <td>
                                <span style="font-weight: bold; color:#010133">
                                    <?php echo $rma['nombre_us'] ?>
                                </span>
                                <?php $freg_ma = $rma['freg_ma'];

                                // Verificar si la fecha es nula
                                if ($freg_ma !== null) {
                                    // Intentar crear un objeto DateTime
                                    $fechaOriginalObj = DateTime::createFromFormat('Y-m-d H:i:s', $freg_ma);

                                    // Verificar si la conversión fue exitosa
                                    if ($fechaOriginalObj !== false) {
                                        // Obtener la fecha formateada como 'd-m-Y'
                                        $fechaFormateada = $fechaOriginalObj->format('d-m-Y H:i:s');
                                        echo $fechaFormateada;
                                    } else {
                                        echo "La fecha no es válida";
                                    }
                                } else {
                                    echo "La fecha es nula";
                                }


                                ?>


                            </td>

                            <td align="center">
                                <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalCardInfomatri" data-bs-whatever="@mdo" onclick="infoI('<?php echo $rma['id_ma'] ?? ''; ?>', '<?php echo $rma['monto_ma'] ?? ''; ?>', '<?php echo $rma['nombre_de'] ?? ''; ?>', '<?php echo $rma['monto_de'] ?? ''; ?>', '<?php echo $rma['observacion_ma'] ?? ''; ?>')">
                                    <i class="fa-solid fa-info"></i>
                                </a>
                            </td>

                            <td>


                                <center>
                                    <?php
                                    $texto = ""; // Asignar un valor por defecto a $texto

                                    // Realizar la consulta SQL para obtener la última boleta y su estado
                                    $sql_fecha = "SELECT estadodeu_bo, ffin_bo FROM boleta WHERE id_ma = $id ORDER BY ffin_bo DESC LIMIT 1";
                                    $f_fecha = mysqli_query($cn, $sql_fecha);

                                    // Obtener los datos de la última boleta si existen
                                    if ($r_fecha = mysqli_fetch_assoc($f_fecha)) {
                                        $inicio = $r_fecha['ffin_bo']; // Fecha de finalización de la última boleta
                                        $texto = $r_fecha['estadodeu_bo']; // Estado de la última boleta
                                    }

                                    // Verificar si el estado de la última boleta no es "DEUDA"
                                    if ($texto != "DEUDA") {
                                        // Si no es "DEUDA", mostrar el botón
                                    ?>
                                        <!-- Botón de registro -->
                                        <button class="turno btn btn-sm " data-bs-toggle="modal" data-bs-target="#Registrar" data-bs-whatever="@mdo" style="cursor: pointer; background-color: #4385F5; color: #fff;" onclick="cargar_registro({
                                            'mensualidad': '<?php echo $rma['mensualidad_ma']; ?>',
                                            'volver':'<?php echo $id; ?>',
                                            'fini':'<?php echo $inicio; ?>',
                                            'ffin':'<?php echo $final; ?>'
                                        })">
                                            <!-- Ícono y texto del botón -->
                                            <span style="font-weight: 800;"> + </span>
                                            <i class="fa-solid fa-file-invoice"></i>
                                        </button>
                                    <?php
                                        // Cierre del bloque PHP después de mostrar el botón
                                    }
                                    ?>

                                    <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalMatriculaEditar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info_Editar({
                                                        'id_maU': '<?php echo $rma['id_ma'] ?? ''; ?>',
                                                        'monto_maU': '<?php echo $rma['monto_ma'] ?? ''; ?>',
                                                        'mensualidad_maU': '<?php echo $rma['mensualidad_ma'] ?? ''; ?>',
                                                        'matricula_maU': '<?php echo $rma['monto_ma'] ?? ''; ?>',
                                                        'estado_maU': '<?php echo $rma['estado_ma'] ?? ''; ?>',
                                                        'observacion_maU': '<?php echo $rma['observacion_ma'] ?? ''; ?>',
                                                        'id_ciU': '<?php echo $rma['id_ci'] ?? ''; ?>',
                                                        'id_usU': '<?php echo $rma['id_us'] ?? ''; ?>',
                                                        'id_deU': '<?php echo $rma['id_de'] ?? ''; ?>'
                                                    });">
                                        <i class="fas fa-edit"> </i></a>
                                    <a class="btn btn-sm btn-danger btn-circle " data-bs-toggle="modal" data-bs-target="#DeleteModalMatricula" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info_Eliminar({
                                                'id_maD': '<?php echo $rma['id_ma'] ?? ''; ?>'
                                                });">
                                        <i class="fas fa-trash"> </i></a>

                                    <a class="btn btn-sm btn-warning btn-circle " data-bs-toggle="modal" data-bs-target="#PDFMatricula" data-bs-whatever="@mdo" target="_parent" onclick="cargar_pdf(<?php echo $rma['id_ma'] ?? ''; ?>)">
                                        <i class="fas fa-print"> </i></a>
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



    <!-- Para traer el modal boleta  -->
    <?php
    include_once('app/controllers/boleta/Modal_boleta.php');

    ?>


    <div class="modal fade" id="ModalCardInfomatri" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="number" name="u_idma" id="id_maU" hidden>
                    <p><strong>Monto de la matrícula:</strong> <span id="monto_ma"></span></p>
                    <p><strong>Tipo de descuento:</strong> <span id="nombre_de"></span></p>
                    <p><strong>Monto del descuento:</strong> <span id="monto_de"></span></p>
                    <p><strong>Observación:</strong> <span id="observacion_ma"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function infoI(id_ma, monto_ma, nombre_de, monto_de, observacion_ma) {
            document.getElementById("id_maU").value = id_ma;
            document.getElementById("monto_ma").textContent = monto_ma || "No disponible";
            document.getElementById("nombre_de").textContent = nombre_de || "No disponible";
            document.getElementById("monto_de").textContent = monto_de || "No disponible";
            document.getElementById("observacion_ma").textContent = observacion_ma || "No se han registrado observaciones.";
        }
    </script>





    <!-- MODAL PARA REGISTRAR REGISTRAR  -->
    <div class="modal fade" id="ModalMatriculaRegistro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">REGISTRO MATRICULA:</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <form action="./app/controllers/matricula/R_matricula.php" method="post">

                    <div class="modal-body row g-3">
                        <!-- Columna izquierda -->
                        <div class="col-md-12">
                            <h3 class="title"> Datos del Alumno</h3>
                            <hr>
                        </div>
                        <div class="col-md-6">

                            <div class="col-12 mb-3">
                                <label for="alumno" class="col-form-label" style="color: black;">Buscar:</label>
                                <div style="position: relative;">
                                    <input type="number" name="r_idal" id="r_idal" hidden>
                                    <input type="text" name="r_" placeholder="Buscar por nombre o DNI" class="form-control" id="buscadorAl">
                                    <ul id="listaAlumnos" style="position: absolute; top: 100%; left: 0; z-index: 1000;"></ul>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="nombre" class="col-form-label" style="color: black;">Nombre y apellidos:</label>
                                <input type="text" placeholder="Buscar por nombre o DNI" class="form-control" id="r_nombre" readonly required>
                            </div>
                        </div>

                        <!-- Columna derecha -->
                        <div class="col-md-6">
                            <div class="col-12 mb-3">
                                <label for="area" class="col-form-label" style="color: black;">Área:</label>
                                <input type="text" placeholder=" " class="form-control" id="r_area" readonly required>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="carrera" class="col-form-label" style="color: black;">Carrera:</label>
                                <input type="text" placeholder=" " class="form-control" id="r_carrera" readonly required>
                            </div>
                        </div>
                        <!-- Columna izquierda -->
                        <div class="col-md-12">
                            <h3 class="title"> Datos del Ciclo</h3>
                            <hr>
                        </div>


                        <div class="col-md-6">
                            <div class="col-12 mb-3">
                                <label for="ciclo" class="col-form-label" style="color: black;">Ciclo:</label>
                                <div style="position: relative;">

                                    <select name="r_lstciclo" id="select-ciclo" class="form-control">
                                        <option value="" disabled selected>Selecciona un Ciclo</option>
                                        <?php
                                        $sqlmatric = "SELECT ci.*  , pe.* FROM ciclo as ci INNER JOIN  periodo pe
                                                ON ci.id_pe = pe.id_pe 
                                                WHERE estado_ci='ACTIVO'";
                                        $fsql = mysqli_query($cn, $sqlmatric);

                                        while ($r = mysqli_fetch_assoc($fsql)) {
                                        ?>
                                            <option value="<?php echo $r['id_ci'] ?>"> <?php echo $r['nombre_pe'] . ' ' . $r['nombre_ci'] ?> </option>
                                        <?php

                                        }
                                        ?>


                                    </select>

                                </div>
                            </div>


                        </div>
                        <div class="col-md-6">

                            <div class="col-12 mb-3">
                                <label for="nombre" class="col-form-label" style="color: black;">Turno:</label>
                                <textarea class="form-control" id="r_turno" readonly required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h3 class="title"> Datos de la matricula</h3>
                            <hr>
                        </div>

                        <div class="col-md-6">

                            <div class="col-12 mb-3">
                                <label for="monto" class="col-form-label" style="color: black;">Costo De Matricula:</label>
                                <input type="number" name="r_montoM" placeholder="Ingrese el costo" class="form-control" id="r_montoM" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="r_descuento" class="col-form-label" style="color: black;">Descuento:</label>
                                <br>
                                <select class="form-control form-select-sm mb-3" name="r_lstdesc" id="select-desc">
                                    <option value="" disabled>Selecciona un descuento</option>
                                    <?php

                                    $sqldes = "SELECT * FROM descuento where estado_de = 'ACTIVO'";
                                    $fdes = mysqli_query($cn, $sqldes);

                                    while ($rdes = mysqli_fetch_assoc($fdes)) {


                                    ?>
                                        <option value="<?php echo $rdes['id_de'] ?> "> <?php echo $rdes['nombre_de'] . ' -  S/' . $rdes['monto_de'] ?> </option>

                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="comentario" class="col-form-label" style="color: black;">Observación:</label>

                                <textarea class="form-control" name="r_comentario" id="" cols="20" rows="10"></textarea>


                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="col-12 mb-3">
                                <label for="monto" class="col-form-label" style="color: black;">Monto Mensual:</label>
                                <input type="number" name="r_menCiclo" class="form-control" readonly id="r_menCiclo" required>


                            </div>

                            <div class="col-12 mb-3">
                                <label for="monto descuento" class="col-form-label" style="color: black;">Monto Descontado:</label>
                                <input type="number" name="r_montoD" class="form-control" readonly id="r_montdes">

                            </div>
                            <hr>

                            <div class="col-12 mb-3">
                                <label for="desciuento" class="col-form-label" style="color: black;">Monto Fijo:</label>
                                <input type="number" name="r_montoF" class="form-control" readonly id="r_montof" required>


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

    <!-- MODAL PARA EDITAR EL CICLO  -->
    <div class="modal fade" id="ModalMatriculaEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">EDITAR MATRICULA:</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <form action="./app/controllers/matricula/U_matricula.php" method="post">

                    <input type="number" name="u_idma" class="form-control" id="id_maU" hidden>

                    <div class="modal-body row g-3">
                        <!-- Columna izquierda -->
                        <div class="col-md-12">
                            <h3 class="title"> Datos del Ciclo</h3>
                            <hr>
                        </div>


                        <div class="col-md-6">
                            <div class="col-12 mb-3">
                                <label for="ciclo" class="col-form-label" style="color: black;">Ciclo:</label>
                                <div style="position: relative;">

                                    <select name="u_lstciclo" id="select-cicloU" class="form-control">
                                        <option value="" disabled selected>Selecciona un Ciclo</option>
                                        <?php
                                        $sqlmatric = "SELECT ci.*  , pe.* FROM ciclo as ci INNER JOIN  periodo pe
                                                ON ci.id_pe = pe.id_pe 
                                                WHERE estado_ci='ACTIVO'";
                                        $fsql = mysqli_query($cn, $sqlmatric);

                                        while ($r = mysqli_fetch_assoc($fsql)) {
                                        ?>
                                            <option value="<?php echo $r['id_ci']; ?>"> <?php echo $r['nombre_pe'] . ' ' . $r['nombre_ci'] ?> </option>
                                        <?php

                                        }
                                        ?>


                                    </select>

                                </div>
                            </div>


                        </div>
                        <div class="col-md-6">

                            <div class="col-12 mb-3">
                                <label for="nombre" class="col-form-label" style="color: black;">Turno:</label>
                                <textarea class="form-control" id="r_turnoU" readonly required></textarea>
                            </div>
                        </div>
                        <!-- <div class="col-md-12">

                        <div class="col-6 mb-3">
                            <label for="nombre" class="col-form-label" style="color: black;">Precio:</label>
                            <input class="form-control" id="r_precio" readonly required>
                        </div>
                    </div> -->

                        <div class="col-md-12">
                            <h3 class="title"> Datos de la matrícula</h3>
                            <hr>
                        </div>

                        <div class="col-md-6">

                            <div class="col-12 mb-3">
                                <label for="monto" class="col-form-label" style="color: black;">Costo De Matrícula:</label>
                                <input type="number" name="u_montoM" placeholder="Ingrese el costo" class="form-control" id="montoMU">
                            </div>

                            <div class="col-12 mb-3">
                                <label for="r_descuento" class="col-form-label" style="color: black;">Descuento:</label>
                                <br>
                                <select class="form-control form-select-sm mb-3" name="u_lstdesc" id="select-descU">
                                    <option value="" disabled>Selecciona un descuento</option>
                                    <?php

                                    $sqldes = "SELECT * FROM descuento where estado_de = 'ACTIVO'";
                                    $fdes = mysqli_query($cn, $sqldes);

                                    while ($rdes = mysqli_fetch_assoc($fdes)) {


                                    ?>
                                        <option value="<?php echo $rdes['id_de'] ?>"> <?php echo $rdes['nombre_de'] . ' -  S/' . $rdes['monto_de'] ?> </option>

                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="comentario" class="col-form-label" style="color: black;">Observación:</label>

                                <textarea class="form-control" name="u_comentario" id="comentarioU" cols="20" rows="10"></textarea>


                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="col-12 mb-3">
                                <label for="monto" class="col-form-label" style="color: black;">Monto Mensual:</label>
                                <input type="number" name="r_menCiclo" class="form-control" readonly id="r_menCicloU" required>


                            </div>

                            <div class="col-12 mb-3">
                                <label for="monto descuento" class="col-form-label" style="color: black;">Monto Descontado:</label>
                                <input type="number" name="r_montoD" class="form-control" readonly id="r_montdesU">

                            </div>
                            <hr>

                            <div class="col-12 mb-3">
                                <label for="desciuento" class="col-form-label" style="color: black;">Monto Fijo:</label>
                                <input type="number" name="u_montoF" class="form-control" readonly id="r_montofU" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label" for="estado">Estado</label>

                                <select class="form-control" name="txt_estado_edit" id="U_lstestado" required>
                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="FINALIZADO">FINALIZADO</option>
                                    <option value="ANULADO">ANULADO</option>

                                </select>


                            </div>



                        </div>



                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="registrar">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL PARA ELIMINAR EL CICLO  -->
    <div class="modal fade  " id="DeleteModalMatricula" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #010133; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h4>
                </div>
                <div class="modal-body">
                    <form action="app/controllers/matricula/D_matricula.php" method="POST">
                        ¿Estás seguro de que quieres eliminar esta Matrícula?
                        <input hidden type="number" name="id_maD" id="id_maD">
                        <button class="btn btn-danger btn-circle">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA PDF -->
    <div class="modal fade  " id="PDFMatricula" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #010133; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">MATRÍCULA DOCUMENTO</h4>
                </div>
                <div class="modal-body">
                    <iframe id='pdfIFrame' width='1100' height='600'></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Colocar antes de los Script  -->
    <?php
    include_once('src/components/parte_inferior.php');
    ?>
    <!-- Verificar Datos de Registrar Matrícula  -->
    <script src="src/assets/js/matricula/verificardatos.js"></script>
    <!-- PARA EL BUSCAR Alumno  -->
    <script src="src/assets/js/matricula/buscaralumno.js"></script>
    <!-- PARA EL CARGAR DATOS DE CICLO  XD-->
    <script src="src/assets/js/matricula/obtenerciclo.js"></script>

    <!-- PARA EL CARGAR DATOS DE DESCUENTO -->

    <script src="src/assets/js/matricula/obtenerdesc.js"></script>

    <!-- PARA EL CARGAR DATOS DE EDITAR MATRÍCULA-->

    <script src="src/assets/js/matricula/cargardatosEditar.js"></script>
    <!-- PARA EL CARGAR DATOS DE ELIMINAR MATRÍCULA-->

    <script src="src/assets/js/matricula/cargardatosEliminar.js"></script>


    <!-- <script src="src/assets/js/datatableIntegration.js"></script> -->

    <script>
        $(document).ready(function() {
            var table = $('#table_matricula').DataTable({
                responsive: true,
                language: {
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontraron resultados",
                    "info": " _TOTAL_ registros",
                    "infoEmpty": "No hay registros para mostrar",
                    "infoFiltered": "(filtrado de _MAX_  registros)",
                    "sSearch": "Buscar:",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "sProcessing": "Cargando...",
                },
                dom: 'Bfrtilp',
                buttons: [{
                        extend: 'excelHtml5',
                        autofilter: true,
                        text: '<i class="fa-regular fa-file-excel"></i>',
                        titleAttr: 'Exportar a Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 6, 7, 8, 9]
                        }

                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa-regular fa-file-pdf"></i>',
                        titleAttr: 'Exportar a PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 6, 7, 8, 9]
                        },
                        customize: function(doc) {

                            doc.content[1].table.body[0].forEach(function(h) {
                                h.fillColor = 'rgb(1, 1, 51)';
                            });
                        },
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa-solid fa-print"></i>',
                        titleAttr: 'Imprimir',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 6, 7, 8, 9]
                        },

                    },
                ]
            });

            new $.fn.dataTable.FixedHeader(table);
        });

        function cargar_pdf(cod) {
            document.getElementById('pdfIFrame').src = 'app/controllers/matricula/PDF_matricula.php?cod=' + cod;
        }
    </script>

    <?php


    ?>