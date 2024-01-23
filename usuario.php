<?php
include_once("auth.php");
include_once("inc/estructura/parte_superior.php");
include('config/dbconnect.php');

$cod = $_SESSION["usuario"];
$sql = "SELECT * FROM usuario as us INNER JOIN rol as ro ON us.id_ro = ro.id_ro WHERE us.id_us = $cod AND ro.nombre_ro='ADMINISTRADOR'";

// Execute the query and get the result
$resultado = mysqli_query($cn, $sql);

// Check if the user has the role of ADMINISTRADOR
if ($resultado && mysqli_num_rows($resultado) > 0) {
?>
    <link rel="stylesheet" href="assets/css/usuario/usuario.css">
    <link rel="stylesheet" href="assets/css/datatables/datatables.css">
    <link rel="stylesheet" href="assets/css/bootstrap/bootstrap.css">

    <div class="app-body-main-content">
        <div>
            <p>Pages<span> / Usuario</span></p>
            <h3>Usuario</h3>
        </div>
        <div class="main-content">
            <div>
                <button class="usuario" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                    Nuevo Usuario
                </button>
            </div>
            <div class="col-md-12">
                <table class="table table-striped" id="table_usuario">
                    <thead style="color: #fff; background-color:#f05941;">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Contraseña</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                            <th>Estado</th>
                            <th>Rol</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlu = "SELECT u.*, ro.* FROM usuario u INNER JOIN rol ro ON u.id_ro = ro.id_ro ORDER BY u.id_us DESC";
                        $f = mysqli_query($cn, $sqlu);

                        while ($r = mysqli_fetch_assoc($f)) {
                        ?>
                            <tr>
                                <td><?php echo $r['id_us'] ?></td>
                                <td><?php echo $r['usuario_us'] ?></td>
                                <td><?php echo $r['password_us'] ?></td>
                                <td><?php echo $r['nombre_us'] ?></td>
                                <td><?php echo $r['telefono_us'] ?></td>
                                <td><?php echo $r['estado_us'] ?></td>
                                <td><?php echo $r['nombre_ro'] ?></td>
                                <td>
                                    <a class="btn btn-lg btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                                            'usuario': '<?php echo $r['usuario_us'] ?? ''; ?>',
                                            'pass': '<?php echo $r['password_us'] ?? ''; ?>',
                                            'nombre': '<?php echo $r['nombre_us'] ?? ''; ?>',
                                            'telefono': '<?php echo $r['telefono_us'] ?? ''; ?>',
                                            'estado': '<?php echo $r['estado_us'] ?? ''; ?>',
                                            'rol': '<?php echo $r['nombre_ro'] ?? ''; ?>',
                                            'id': '<?php echo $r['id_us'] ?? ''; ?>',
                                        });">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="usuario/D_usuario.php?cod=<?php echo $r['id_us'] ?>" class="btn btn-lg btn-danger" target="parent"><i class="fas fa-trash"></i></a>
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
    <!-- MODAL PARA EDITAR Usuario  -->
    <div class="modal fade  " id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #04f2da; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">EDITAR USUARIO:</h4>

                    <h1 id=""></h1>
                    <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="usuario/U_usuario.php" method="post">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="usuario" class="col-form-label" style="color: black;">Usuario:</label>
                                    <input type="text" name="txtusuario" placeholder="Ingrese el usuario" class="form-control" id="usuario" required>
                                </div>
                                <div class="mb-3">
                                    <label for="pass" class="col-form-label" style="color: black;">Contraseña:</label>
                                    <input type="password" name="txtpass" placeholder="Ingrese su contraseña" class="form-control" id="pass2" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Confpass" class="col-form-label" style="color: black;">Confirmar Contraseña:</label>
                                    <input type="password" name="txtconfpass" placeholder="Repita su contraseña" class="form-control" id="Confpass2" required>
                                    <p id="" style="display: none;">Corregir No es igual a la contraseña</p>
                                </div>

                                <div class="mb-3">
                                    <label for="nombre" class="col-form-label" style="color: black;">Nombre:</label>


                                    <input type="text" name="txtnombre" placeholder="Ingrese el nombre completo" maxlength="50" class="form-control" id="nombre" required>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="telefono" class="col-form-label" style="color: black;">Telefono:</label>

                                    <input type="text" name="txttelefono" placeholder="Ingrese 9 digitos" class="form-control" id="telefono" required maxlength="9">


                                </div>


                                <div class="mb-3">
                                    <label for="rol" class="col-form-label" style="color: black;">Rol:</label>
                                    <select class="form-select form-select-sm mb-3" name="lstrol" id="rol" required>
                                        <option value="" disabled>Selecciona un rol</option>
                                        <?php
                                        $sql = "SELECT * FROM rol";
                                        $f = mysqli_query($cn, $sql);

                                        // Fetch the selected value from JavaScript
                                        $selectedValue = isset($_GET['selectedValue']) ? $_GET['selectedValue'] : '';

                                        while ($r = mysqli_fetch_assoc($f)) {
                                            // Compare with the selected value
                                            $selected = ($r['nombre_ro'] == $selectedValue) ? "selected" : "";
                                        ?>
                                            <option value="<?php echo $r['nombre_ro'] ?>" <?php echo $selected ?> data-id-rol="<?php echo $r['id_ro'] ?>"><?php echo $r['nombre_ro'] ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="estado" class="col-form-label" style="color: black;">Estado:</label>

                                    <select class="form-select form-select-sm mb-3" name="lstestado" id="estado" required>

                                        <option value="" disabled selected>Selecciona un Estado</option>
                                        <option value="ACTIVO" require>ACTIVO</option>
                                        <option value="INACTIVO">INACTIVO</option>

                                    </select>


                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id_rol_seleccionado" id="id_rol_seleccionado" value="">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                            <button type="submit" class="btn btn-primary" id="">Editar</button>
                            <input type="hidden" name="id_us" id="id_us" value="">

                        </div>
                    </form>
                </div>



            </div>
        </div>
        <!-- Page-body end -->
    </div>

    <!-- MODAL PARA REGISTRO Usuario  -->
    <div class="modal fade  " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #0B5ED7; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">REGISTRO USUARIO:</h4>
                    <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <form action="usuario.php" method="get">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="usuario" class="col-form-label" style="color: black;">Usuario:</label>
                                    <input type="text" name="txtusuario" placeholder="Ingrese el usuario" class="form-control" id="usuario" required>
                                </div>
                                <div class="mb-3">
                                    <label for="pass" class="col-form-label" style="color: black;">Contraseña:</label>
                                    <input type="password" name="txtpass" placeholder="Ingrese su contraseña" class="form-control" id="pass" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Confpass" class="col-form-label" style="color: black;">Confirmar Contraseña:</label>
                                    <input type="password" name="txtconfpass" placeholder="Repita su contraseña" class="form-control" id="Confpass" required>
                                    <p id="corrector" style="display: none;">Corregir No es igual a la contraseña</p>
                                    <p id="Bueno" style="display: none;">Corregir No es igual a la contraseña</p>
                                </div>

                                <div class="mb-3">
                                    <label for="nombre" class="col-form-label" style="color: black;">Nombre:</label>


                                    <input type="text" name="txtnombre" placeholder="Ingrese el nombre completo" maxlength="50" class="form-control" id="nombre" required>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="telefono" class="col-form-label" style="color: black;">Telefono:</label>

                                    <input type="text" name="txttelefono" placeholder="Ingrese 9 digitos" class="form-control" id="telefono" required maxlength="9">


                                </div>


                                <div class="mb-3">
                                    <label for="rol" class="col-form-label" style="color: black;">Rol:</label>

                                    <select class="form-select form-select-sm mb-3" name="lstrol" id="rol" required>

                                        <option value="" disabled selected>Selecciona un rol</option>

                                        <?php
                                        $sql = "SELECT * FROM rol";
                                        $f = mysqli_query($cn, $sql);

                                        while ($r = mysqli_fetch_assoc($f)) {


                                        ?>
                                            <option value="<?php echo $r['id_ro'] ?>"><?php echo $r['nombre_ro'] ?></option>

                                        <?php
                                        }

                                        ?>


                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="estado" class="col-form-label" style="color: black;">Estado:</label>

                                    <select class="form-select form-select-sm mb-3" name="lstestado" id="estado" required>

                                        <option value="" disabled selected>Selecciona un Estado</option>
                                        <option value="ACTIVO" require>ACTIVO</option>
                                        <option value="INACTIVO">INACTIVO</option>

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




<?php
}
include_once("inc/estructura/parte_inferior.php");
?>
<script type="text/javascript">
    const pass = document.getElementById('pass');
    const confpass = document.getElementById('Confpass');
    const corrector = document.getElementById('corrector');
    const btnregistrar = document.getElementById('registrar');
    // Asocia la función al evento 'input' en ambos campos de contraseña
    //pass.addEventListener('input', verificar);
    confpass.addEventListener('input', verificar);

    function verificar() {
        // Verifica si las contraseñas son iguales
        if (pass.value === confpass.value) {
            // Oculta el mensaje de error
            corrector.style.display = 'none';
            btnregistrar.style.display = 'block';

        } else {
            // Muestra el mensaje de error
            corrector.style.display = 'block';
            corrector.style.color = 'red';
            btnregistrar.style.display = 'none';
        }
    }


    function cargar_info(dato) {
        document.getElementById('usuario').value = dato.usuario;
        document.getElementById('pass2').value = dato.pass;
        document.getElementById('Confpass2').value = dato.pass;
        document.getElementById('nombre').value = dato.nombre;
        document.getElementById('telefono').value = dato.telefono;
        document.getElementById('estado').value = dato.estado;
        document.getElementById('rol').value = dato.rol;
        document.getElementById('id_us').value = dato.id;

    }

    $(document).ready(function() {
        $('#rol').on('change', function() {
            // Obtener el id_ro del rol seleccionado
            var idRolSeleccionado = $(this).find(':selected').data('id-rol');

            // Actualizar el valor del input hidden
            $('#id_rol_seleccionado').val(idRolSeleccionado);
        });
    });


    
    !-- //PARA EDITAR  -->

    // JavaScript to capture the selected value and send it to PHP
    document.getElementById('rol').addEventListener('change', function() {
        var selectedValue = this.value;
        // Send the selected value to PHP using AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Do nothing, just send the value to PHP
            }
        };
        xhr.open('GET', 'usuario.php?selectedValue=' + selectedValue, true);
        xhr.send();
    });



    // DataTable initialization and options
    let table = new DataTable('#table_usuario', {
        language: {
            // ... (Your DataTable language options) ...
        },
        responsive: "true",
        dom: 'Bfrtilp',
        buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa-regular fa-file-excel"></i> ',
                titleAttr: 'Exportar a Excel',
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa-regular fa-file-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                orientation: 'landscape'
            },
            {
                extend: 'print',
                text: '<i class="fa-solid fa-print"></i>',
                titleAttr: 'Imprimir',
            },
        ]
    });
</script>