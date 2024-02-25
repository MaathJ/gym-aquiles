<?php
include_once('auth.php');
include_once("inc/estructura/parte_superior.php");
include_once('config/dbconnect.php');
?>
<link rel="stylesheet" src="style.css" href="assets/css/cliente/cliente.css">
<link rel="stylesheet" src="style.css" href="assets/css/datatables/datatables.css">
<link rel="stylesheet" src="style.css" href="assets/css/bootstrap/bootstrap.css">
<div class="app-body-main-content">
    <div>
        <p>Pages<span> / Cliente</span></p>
        <h3>Cliente</h3>
    </div>
    <div class="main-content">
        <div>
            <button class="cliente" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                Nuevo Cliente
            </button>
        </div>
        <div class="col-md-12" style="background-color: white; padding: 1rem; border-radius: 1rem;">
            <table class="table  table_id" id="table_cliente" style="font-size: .8rem;">
                <thead align="center" class="" style="color: #fff;">
                    <tr align="center">
                        <th class="text-center"> ID </th>
                        <th class="text-center"> FOTO </th>
                        <th class="text-center"> Nombre </th>
                        <th class="text-center"> Apellido </th>
                        <th class="text-center"> DNI </th>
                        <th class="text-center"> Telefono </th>
                        <th class="text-center"> Edad </th>
                        <th class="text-center"> Genero </th>
                        <th class="text-center"> Direc. </th>
                        <th class="text-center"> Estado</th>
                        <th class="text-center"> F.Registro</th>
                        <th class="text-center"> Opciones</th>
                    </tr>
                </thead>
                <?php
                include('config/dbconnect.php');
                $sql = "select * from cliente";
                $f = mysqli_query($cn, $sql);
                while ($r = mysqli_fetch_assoc($f)) {


                ?>

                    <td align="center"><?php echo $r['id_cli'] ?></td>
                    <td align="center"><img style="border-radius: 50%; object-fit: cover;" src="assets/images/cliente/<?php echo $r['dni_cli'] ?>.jpg" width="30px" height="30px"></td>
                    <td align="center"><?php echo $r['nombre_cli'] ?></td>
                    <td align="center"><?php echo $r['apellido_cli'] ?></td>
                    <td align="center"><?php echo $r['dni_cli'] ?></td>
                    <td align="center"><?php echo $r['telefono_cli'] ?></td>
                    <td align="center"><?php echo $r['edad_cli'] ?></td>
                    <td align="center"><?php echo $r['genero_cli'] ?></td>
                    <td align="center"><?php echo $r['direccion_cli'] ?></td>
                    <td>
                        <button class="<?php echo ($r['estado_cli'] == 'ACTIVO') ? 'active-button' : 'inactive-button'; ?>">
                            <?php echo $r['estado_cli'] ?>
                        </button>
                    </td>
                    <td align="center"><?php echo $r['fecha_cli'] ?></td>
                    <td style="display: flex; flex-direction: row; gap: 8px;">
                            <a class="btn-sm btn btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#exampleModal2" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                                                        'id_cli': '<?php echo $r['id_cli'] ?? ''; ?>',
                                                        'nombre': '<?php echo $r['nombre_cli'] ?? ''; ?>',
                                                        'apellido': '<?php echo $r['apellido_cli'] ?? ''; ?>',
                                                        'dni': '<?php echo $r['dni_cli'] ?? ''; ?>',
                                                        'telefono': '<?php echo $r['telefono_cli'] ?? ''; ?>',
                                                        'edad': '<?php echo $r['edad_cli'] ?? ''; ?>',
                                                        'genero': '<?php echo $r['genero_cli'] ?? ''; ?>',
                                                        'direccion': '<?php echo $r['direccion_cli'] ?? ''; ?>',
                                                        'estado': '<?php echo $r['estado_cli'] ?? ''; ?>',
                                                        'enfermedad': '<?php echo $r['enfermedad_cli'] ?? ''; ?>'
                                                    });">
                                <i class="fas fa-edit"> </i>
                            </a>


                            <a href="Cliente/D_cliente.php?d=<?php echo $r['id_cli'] ?>" class="btn-sm btn btn-danger btn-circle" data-bs-toggle="modal" data-bs-target="#ModalEliminarD" data-bs-whatever="@mdo" target="_parent" onclick="cargar_infoD('<?php echo $r['id_cli'] ?? ''; ?>');">
                                <i class="fas fa-trash"></i>
                            </a>

                            <div class="modal fade" id="ModalEliminarD" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                                            <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación:</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form id="eliminarClienteForm" action="Cliente/D_cliente.php" method="get">
                                                <h4>IMPORTANTE: SE ELIMINARÁN MATRÍCULAS Y ASISTENCIAS DEL CLIENTE, ¿Está seguro de continuar?</h4>
                                                <input type="hidden" name="d" id="id_clienteD">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                                                    <button type="submit" class="btn btn-danger">ELIMINAR</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function cargar_infoD(idCliente) {
                                    document.getElementById('id_clienteD').value = idCliente;
                                }
                            </script>



                            <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalCardInfomatri" data-bs-whatever="@mdo" onclick="infoI
                                ('<?php echo $r['id_cli'] ?? ''; ?>', '<?php echo $r['nombre_cli'] ?? ''; ?>', 
                                '<?php echo $r['apellido_cli'] ?? ''; ?>', '<?php echo $r['dni_cli'] ?? ''; ?>', '<?php echo $r['telefono_cli'] ?? ''; ?>', 
                                '<?php echo $r['edad_cli'] ?? ''; ?>', 
                                '<?php echo $r['genero_cli'] ?? ''; ?>', 
                                '<?php echo $r['direccion_cli'] ?? ''; ?>', 
                                '<?php echo $r['estado_cli'] ?? ''; ?>', 
                                '<?php echo $r['fecha_cli'] ?? ''; ?>', 
                                '<?php echo $r['enfermedad_cli'] ?? ''; ?>')">
                                <i class="fa-solid fa-info"></i>
                            </a>







                            <div class="modal fade" id="ModalCardInfomatri" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="card-user-modal ">
                                                <div class="card-logo">


                                                </div>
                                                <div class="card-important-info">

                                                    <input type="number" name="u_idcli" id="id_cliU" hidden>
                                                    <div class="user-name" id="nom_cli" style="color: #010133; font-weight: bold; font-size: 1rem;">
                                                    </div>
                                                    <div class="user-edad" id="apell_cli" style="color: #010133; font-weight: bold; font-size: 1rem;">
                                                    </div>
                                                    <div class="card-cont-important-info">
                                                        <div class="info-item">
                                                            <span id="est_cli"></span>
                                                        </div>
                                                        <div class="info-item">
                                                            <span id="dni_cli"></span>
                                                        </div>
                                                        <div class="info-item">
                                                            <span id="edad_cli"></span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="card-more-info">
                                                    <div class="info-user-more telefono">
                                                        <i class="fa-solid fa-phone"></i>
                                                        <span id="tel_cli"></span>
                                                    </div>
                                                    <div class="info-user-more direccion">
                                                        <i class="fa-solid fa-house"></i>
                                                        <span id="direc_cli"></span>
                                                    </div>
                                                    <div class="info-user-more colegio">
                                                        <i class="fa-solid fa-venus-mars"></i>
                                                        <span id="gen_cli"></span>
                                                    </div>
                                                    <div class="info-user-more universidad">
                                                        <i class="fa-solid fa-calendar-days"></i>
                                                        <span id="fech_cli"></span>
                                                    </div>
                                                    <!-- Icono para Área -->
                                                    <div class="info-user-more area" style="align-items: center;">
                                                        <i class="fa-solid fa-virus"></i>
                                                        <span id="enfer_cli"></span>
                                                    </div>



                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>



                            <script>
                                function infoI(id_cli, nombre_cli, apellido_cli, dni_cli, telefono_cli, edad_cli, genero_cli, direccion_cli, estado_cli, fecha_cli, enfermedad_cli) {
                                    document.getElementById("id_cliU").value = id_cli;
                                    document.getElementById("nom_cli").textContent = nombre_cli || "No disponible";
                                    document.getElementById("apell_cli").textContent = apellido_cli || "No disponible";
                                    document.getElementById("dni_cli").textContent = dni_cli || "No disponible";
                                    document.getElementById("tel_cli").textContent = telefono_cli || "No disponible";
                                    document.getElementById("edad_cli").textContent = edad_cli || "No disponible";
                                    document.getElementById("gen_cli").textContent = genero_cli || "No disponible";
                                    document.getElementById("direc_cli").textContent = direccion_cli || "No disponible";
                                    document.getElementById("est_cli").textContent = estado_cli || "No disponible";
                                    document.getElementById("fech_cli").textContent = fecha_cli || "No disponible";
                                    document.getElementById("enfer_cli").textContent = enfermedad_cli || "No disponible";
                                }
                            </script>


                    </td>

                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
        <div>
        </div>




        <div class="modal fade  " id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                        <h4 class="modal-title" id="exampleModalLabel"> EDITAR REGISTRO </h4>
                        <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <form action="Cliente/U_cliente.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label" style="color: black;">Codigo:</label>
                                        <input type="text" name="txtcodigo" class="form-control" id="recipient_name" disabled>
                                        <input type="text" name="txtcodigo2" class="form-control" id="recipient_name2" hidden>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Nombre-name" class="col-form-label" style="color: black;">Nombre:</label>
                                        <input type="text" name="txtnombre" class="form-control" id="nombre_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Apellido-name" class="col-form-label" style="color: black;">Apellido:</label>
                                        <input type="text" name="txtapellido" class="form-control" id="Apellido_name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="Dni-name" class="col-form-label" style="color: black;">Dni:</label>
                                        <input type="number" name="txtdni" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" id="Dni_name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="Estado-name" class="col-form-label" style="color: black;">Estado:</label>
                                        <select name="txtestado" id="txt_estado" class="form-select" aria-label="Default select example">
                                            <option value="ACTIVO">ACTIVO</option>
                                            <option value="SUSPENDIDO">SUSPENDIDO</option>
                                        </select>


                                    </div>

                                </div>

                                <div class="col-md-4">



                                    <div class="mb-3">
                                        <label for="Telefono-name" class="col-form-label" style="color: black;">Teléfono:</label>
                                        <input type="number" name="txttelefono" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="9" id="Telefono_name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="Edad-name" class="col-form-label" style="color: black;">Edad:</label>
                                        <input type="number" name="txtedad" class="form-control" min="0" id="Edad_name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="genero-name" class="col-form-label" style="color: black;">Género:</label>
                                        <input type="text" name="txt_genero" class="form-control" min="0" id="txt_genero" hidden>

                                        <select name="lstgenero2" id="Genero_name2" class="form-select" aria-label="Default select example">

                                            <option value="MASCULINO">MASCULINO</option>
                                            <option value="FEMENINO">FEMENINO</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="Direccion-name" class="col-form-label" style="color: black;">Direccion:</label>
                                        <input type="text" name="txtdireccion" class="form-control" id="Direccion_name" required>
                                    </div>
                                </div>
                                <div class="col-md-4">



                                    <div class="mb-3">
                                        <label for="Enfermedad-name" class="col-form-label" style="color: black;">Enfermedad:</label>
                                        <input type="text" name="txtenfermedad" class="form-control" id="Enfermedad_name">
                                    </div>

                                    <br>
                                    <div class="mb-3" style="margin-left: 15px;">
                                        <img src="assets/images/img_fond.jpg" alt="avatar" id="img2" width="200" height="200">
                                        <input type="file" name="foto2" id="foto2" accept="image/*">
                                        <label class="btn_img btn-danger" for="foto2">CAMBIAR FOTO</label>
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                                <button type="submit" class="btn btn-danger">EDITAR</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- PARA REGISTRAR  -->
        <div class="modal fade  " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                        <h4 class="modal-title" id="exampleModalLabel">REGISTRO INDIVIDUAL</h4>
                        <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <form action="Cliente/R_cliente.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="Nombre-name" class="col-form-label" style="color: black;">Nombre:</label>
                                        <input type="text" name="txtnombre" class="form-control" id="Nombre-name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Apellido-name" class="col-form-label" style="color: black;">Apellido:</label>
                                        <input type="text" name="txtapellido" class="form-control" id="Apellido-name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="Dni-name" class="col-form-label" style="color: black;">Dni:</label>
                                        <input type="number" name="txtdni" class="form-control" id="Dni-name" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" required>

                                    </div>


                                    <div class="mb-3">
                                        <label for="Telefono-name" class="col-form-label" style="color: black;">Teléfono:</label>
                                        <input type="number" name="txttelefono" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="9" id="Telefono-name" required>
                                    </div>

                                </div>

                                <div class="col-md-4">





                                    <div class="mb-3">
                                        <label for="Edad-name" class="col-form-label" style="color: black;">Edad:</label>
                                        <input type="number" name="txtedad" class="form-control" min="0" id="Edad-name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="genero-name" class="col-form-label" style="color: black;">Genero:</label>
                                        <select class="form-control" name="lstgenero" id="Genero-name" class="form-select" aria-label="Default select example">
                                            <option selected> -------- SELECCIONE -------- </option>
                                            <option value="MASCULINO">MASCULINO</option>
                                            <option value="FEMENINO">FEMENINO</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="Direccion-name" class="col-form-label" style="color: black;">Direccion:</label>
                                        <input type="text" name="txtdireccion" class="form-control" id="Direccion-name" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="Enfermedad-name" class="col-form-label" style="color: black;">Enfermedad:</label>
                                        <input type="text" name="txtenfermedad" class="form-control" id="Enfermedad-name">
                                    </div>

                                    <br>

                                    <div class="mb-3" style="margin-left: 15px;">
                                        <img src="assets/images/img_fond.jpg" alt="avatar" id="img" width="200" height="200" required>
                                        <input type="file" class="form-control" name="foto" id="foto" accept="image/*" required>
                                        <label class="btn_img btn-danger" for="foto">CAMBIAR FOTO</label>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                                <button type="submit" class="btn btn-danger">REGISTRARSE</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php
        if (isset($_SESSION['error_client'])) {
            echo
            '<script>
                setTimeout(() => {
                Swal.fire({
                    title: "¡Ups!",
                    text: "' . $_SESSION['error_client'] . '",
                    icon: "error",
                    });
                }, 500);
            </script>';
            unset($_SESSION['error_client']);
        }
        ?>

        <?php
        include_once("inc/estructura/parte_inferior.php");
        ?>

        <script type="text/javascript">
            function cargar_info(dato) {
                if (dato.genero === undefined || dato.genero === null) {
                    console.error("La propiedad 'genero' en 'dato' es nula o indefinida.");
                    return;
                }
                document.getElementById('recipient_name').value = dato.id_cli;
                document.getElementById('recipient_name2').value = dato.id_cli;
                document.getElementById('nombre_name').value = dato.nombre;
                document.getElementById('Apellido_name').value = dato.apellido;
                document.getElementById('Telefono_name').value = dato.telefono;

                document.getElementById('Edad_name').value = dato.edad;
                document.getElementById('Direccion_name').value = dato.direccion;

                document.getElementById('Dni_name').value = dato.dni;
                document.getElementById('Enfermedad_name').value = dato.enfermedad;
                document.getElementById('txt_genero').value = dato.genero;

                var generoSelect = document.getElementById('Genero_name2');

                for (var i = 0; i < generoSelect.options.length; i++) {
                    if (generoSelect.options[i].value == dato.genero) {
                        generoSelect.options[i].selected = true;
                        break;
                    }
                }

                var generoSelect2 = document.getElementById('txt_estado');

                for (var i = 0; i < generoSelect2.options.length; i++) {
                    if (generoSelect2.options[i].value == dato.estado) {
                        generoSelect2.options[i].selected = true;
                        break;
                    }
                }

                document.getElementById('img2').src = "assets/images/cliente/" + dato.dni + ".jpg";


            }


            let table = new DataTable('#table_cliente', {
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
        <script src="assets/js/imagenes/imagenes2.js"></script>
        <script src="assets/js/imagenes/imagenes.js"></script>






        <style type="text/css">
            #foto {
                display: none;
            }

            #foto2 {
                display: none;
            }

            .btn_img {
                width: 200px;
                text-align: center;
                border-radius: 10px;
                margin-top: 5px;
                padding-top: 5px;
                height: 35px;
            }

            .card-cont-important-info {
                display: flex;
                flex-direction: row;
                justify-content: center;
                /* Centrar horizontalmente */
            }

            .info-item {
                margin-right: 20px;
                /* Espacio entre elementos */
            }
        </style>