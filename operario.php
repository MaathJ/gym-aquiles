 <?php
    include('./config/dbconnect.php');
    include_once('auth.php');
    require_once "inc/estructura/parte_superior.php"

    ?>

 <link rel="stylesheet" src="style.css" href="assets/css/matricula/matricula.css">
 <div class="app-body-main-content">

     <div>
         <p>Aquiles<span> / Operario</span></p>
         <h3>Operario</h3>
     </div>
     <div class="main-content">
         <div>
             <button class="matricula" data-bs-toggle="modal" data-bs-target="#ModalRegistroOperario" data-bs-whatever="@mdo">
                 Nuevo Operario
             </button>
         </div>

         <div class="col-md-12" style="background-color: white; padding: 1rem; border-radius: 1rem;">
             <table class="table table-hover table-responsive-sm" id="table_Operario">

                 <thead style="color: white;">
                     <tr>
                         <th class="text-center"> ID </th>
                         <th class="text-center"> FOTO </th>
                         <th class="text-center"> OPERARIO</th>
                         <th class="text-center"> DNI </th>
                         <th class="text-center"> TELEFONO </th>
                         <th class="text-center"> EDAD </th>
                         <th class="text-center"> ESTADO</th>
                         <th class="text-center"> F.REGISTRO</th>
                         <th class="text-center"> TURNO</th>
                         <th class="text-center"> CARGO</th>
                         <th class="text-center"> OPCIONES</th>
                     </tr>
                 </thead>
                 <?php
                    $sql = "SELECT * from operario op inner join cargo cr on op.id_ca=cr.id_ca inner join turno tr on op.id_tu = tr.id_tu ";
                    $f = mysqli_query($cn, $sql);
                    while ($r = mysqli_fetch_assoc($f)) {


                    ?>
                     <td align="center"><?php echo $r['id_op'] ?></td>
                     <td align="center"><img src="assets/images/operario/<?php echo $r['dni_op'] ?>.jpg" width="60px" style="border-radius: 100%; object-fit: cover;" height="60px"></td>
                     <td align="center"><?php echo $r['nombre_op'] . ' ' . $r['apellido_op']  ?></td>

                     <td align="center"><?php echo $r['dni_op'] ?></td>
                     <td align="center"><?php echo $r['telefono_op'] ?></td>
                     <td align="center"><?php echo $r['edad_op'] ?></td>
                     <td align="center">
                                            <button class="<?php echo ($r['estado_op'] == 'ACTIVO') ? 'active-button' : 'waiting-button'; ?>">
                                                <?php echo $r['estado_op'] ?>
                                            </button>
                                        </td>
                     <td align="center"><?php echo $r['fecharegistro_op'] ?></td>
                     <td align="center"><?php echo $r['nombre_tu'] ?></td>
                     <td align="center"><?php echo $r['nombre_ca'] ?></td>
                     <td>
                         <center>

                             <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#exampleModalEditar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                                                        'id': '<?php echo $r['id_op'] ?? ''; ?>',
                                                        'nombre': '<?php echo $r['nombre_op'] ?? ''; ?>',
                                                        'apellido': '<?php echo $r['apellido_op'] ?? ''; ?>',
                                                        'dni': '<?php echo $r['dni_op'] ?? ''; ?>',
                                                        'telefono': '<?php echo $r['telefono_op'] ?? ''; ?>',
                                                        'edad': '<?php echo $r['edad_op'] ?? ''; ?>',
                                                        'estado': '<?php echo $r['estado_op'] ?? ''; ?>',
                                                        'fecha': '<?php echo $r['fecharegistro_op'] ?? ''; ?>',
                                                        'turno': '<?php echo $r['id_tu'] ?? ''; ?>',
                                                        'cargo': '<?php echo $r['id_ca'] ?? ''; ?>'
                                                    });">
                                 <i class="fas fa-edit"> </i></a>

<!-- 
                             <a href="operario/D_operario.php?d=<?php echo $r['id_op'] ?>" class="btn btn-sm btn-danger btn-circle " target="_parent">
                                 <i class="fas fa-trash"> </i></a> -->

                                 <a class="btn btn-sm btn-danger btn-circle" target="_parent" data-bs-toggle="modal" data-bs-target="#DeleteModalOperario" data-bs-whatever="@mdo" data-id="<?php echo $r['id_op']; ?>">
                                    <i class="fas fa-trash"></i>
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
 </div>
 <!-- Page-body end -->
 </div>
 <div id="styleSelector"> </div>
 </div>
 </div>



 <!-- PARA EDITAR  -->

 <div class="modal fade  " id="exampleModalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                 <h4 class="modal-title" id="exampleModalLabel">EDITAR OPERARIO</h4>


                 <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
                 <br>

             </div>
             <span>Es importante Completar todos los campos</span>
             <div class="modal-body">


                 <form action="operario/U_operario.php" method="post" enctype="multipart/form-data">
                     <div class="row">
                         <div class="col-md-4">
                             <div class="mb-3">
                                 <label for="Nombre-name" class="col-form-label" style="color: black;">Nombre:</label>
                                 <input type="text" name="txtnombre" class="form-control" id="u_nombre" placeholder="nombres completo" required>
                             </div>
                             <div class="mb-3">
                                 <label for="Apellido-name" class="col-form-label" style="color: black;">Apellido:</label>
                                 <input type="text" name="txtapellido" class="form-control" id="u_apellido" placeholder="apellidos completo" required>
                             </div>

                             <div class="mb-3">
                                 <label for="Dni-name" class="col-form-label" style="color: black;">Dni:</label>
                                 <input type="number" name="txtdni" class="form-control" id="u_dni" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" placeholder="DNI o Cedula" required>

                             </div>


                             <div class="mb-3">
                                 <label for="Telefono-name" class="col-form-label" style="color: black;">Teléfono:</label>
                                 <input type="number" name="txttelefono" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="ingrese 9 digitos" maxlength="9" id="u_telefono" required>
                             </div>

                         </div>

                         <div class="col-md-4">


                             <div class="mb-3">
                                 <label for="Edad-name" class="col-form-label" style="color: black;">Estado:</label>

                                 <select name="lstestado" id="u_estado" class="form-control">
                                     <option value="" selected>Selecciona un estado</option>

                                     <option value="ACTIVO">ACTIVO</option>
                                     <option value="INACTIVO">INACTIVO</option>
                                 </select>

                             </div>


                             <div class="mb-3">
                                 <label for="Edad-name" class="col-form-label" style="color: black;">Edad:</label>
                                 <input type="number" name="txtedad" class="form-control" min="0" id="u_edad" required>
                             </div>

                             <div class="mb-3">
                                 <label for="genero-name" class="col-form-label" style="color: black;">Cargo:</label>
                                 <select name="lstcargo" id="u_cargo" class="form-select form-select-sm mb-3">

                                     <?php

                                        $sqlUca = "SELECT * FROM cargo WHERE estado_ca ='ACTIVO' ";
                                        $fUca =  mysqli_query($cn, $sqlUca);

                                        while ($rUca = mysqli_fetch_assoc($fUca)) {



                                        ?>
                                         <option value="<?php echo $rUca['id_ca'] ?>"><?php echo $rUca['nombre_ca'] ?></option>

                                     <?php
                                        }

                                        ?>
                                 </select>
                             </div>

                             <div class="mb-3">
                                 <label for="turno-name" class="col-form-label" style="color: black;">Turno:</label>
                                 <select name="lstturn" id="u_turno" class="form-select" aria-label="Default select example">

                                     <?php

                                        $sqlTu = "SELECT * FROM turno WHERE estado_tu ='ACTIVO'";
                                        $ftu =  mysqli_query($cn, $sqlTu);

                                        while ($rt = mysqli_fetch_assoc($ftu)) {



                                        ?>
                                         <option value="<?php echo $rt['id_tu'] ?>"><?php echo $rt['nombre_tu'] ?></option>

                                     <?php
                                        }

                                        ?>
                                 </select>
                             </div>


                         </div>
                         <div class="col-md-4">


                             <br>

                             <div class="mb-3" style="margin-left: 15px;">
                                 <img src="assets/images/img_fond.jpg" alt="avatar" id="img2" width="200" height="200">
                                 <input type="file" name="foto2" id="foto2" accept="image/*">
                                 <label class="btn_img btn-primary" style="background-color:#f05941; border-color: #f05941;" for="foto2">CAMBIAR FOTO</label>
                             </div>
                         </div>
                     </div>

                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                         <button type="submit" class="btn btn-primary" style="background-color:#f05941; border-color: #f05941;">Modificar</button>
                         <input type="hidden" name="cod" id="u_id">
                     </div>

                 </form>
             </div>

         </div>
     </div>
 </div>



 <!-- PARA REGISTRAR  -->
 <div class="modal fade  " id="ModalRegistroOperario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">

     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header " style="background-color: #f05941 ; color: #ffffff;">
                 <h4 class="modal-title" id="exampleModalLabel">REGISTRO OPERARIO</h4>


                 <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
                 <br>

             </div>
             <br>
             <span>Es importante Completar todos los campos</span>
             <div class="modal-body">


                 <form action="operario/R_operario.php" method="post" enctype="multipart/form-data">
                     <div class="row">
                         <div class="col-md-4">
                             <div class="mb-3">
                                 <label for="Nombre-name" class="col-form-label" style="color: black;">Nombre:</label>
                                 <input type="text" name="txtnombre" class="form-control" id="Nombre-name" placeholder="nombres completo" required>
                             </div>
                             <div class="mb-3">
                                 <label for="Apellido-name" class="col-form-label" style="color: black;">Apellido:</label>
                                 <input type="text" name="txtapellido" class="form-control" id="Apellido-name" placeholder="apellidos completo" required>
                             </div>

                             <div class="mb-3">
                                 <label for="Dni-name" class="col-form-label" style="color: black;">Dni:</label>
                                 <input type="number" name="txtdni" class="form-control" id="Dni-name" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" placeholder="DNI o Cedula" required>

                             </div>


                             <div class="mb-3">
                                 <label for="Telefono-name" class="col-form-label" style="color: black;">Teléfono:</label>
                                 <input type="number" name="txttelefono" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="ingrese 9 digitos" maxlength="9" id="Telefono-name" required>
                             </div>

                         </div>

                         <div class="col-md-4">





                             <div class="mb-3">
                                 <label for="Edad-name" class="col-form-label" style="color: black;">Edad:</label>
                                 <input type="number" name="txtedad" class="form-control" min="0" id="Edad-name" required>
                             </div>

                             <div class="mb-3">
                                 <label for="genero-name" class="col-form-label" style="color: black;">Cargo:</label>
                                 <select name="lstcargo" id="Genero-name" class="form-select" aria-label="Default select example">
                                     <option selected> -------- SELECCIONE -------- </option>
                                     <?php

                                        $sql = "SELECT * FROM cargo WHERE estado_ca ='ACTIVO' ";
                                        $f =  mysqli_query($cn, $sql);

                                        while ($r = mysqli_fetch_assoc($f)) {



                                        ?>
                                         <option value="<?php echo $r['id_ca'] ?>"><?php echo $r['nombre_ca'] ?></option>

                                     <?php
                                        }

                                        ?>
                                 </select>
                             </div>

                             <div class="mb-3">
                                 <label for="genero-name" class="col-form-label" style="color: black;">Turno:</label>
                                 <select name="lstturno" id="Genero-name" class="form-select" aria-label="Default select example">
                                     <option selected> -------- SELECCIONE -------- </option>
                                     <?php

                                        $sqlTu = "SELECT * FROM turno WHERE estado_tu ='ACTIVO'";
                                        $ftu =  mysqli_query($cn, $sqlTu);

                                        while ($rt = mysqli_fetch_assoc($ftu)) {



                                        ?>
                                         <option value="<?php echo $rt['id_tu'] ?>"><?php echo $rt['nombre_tu'] ?></option>

                                     <?php
                                        }

                                        ?>
                                 </select>
                             </div>


                         </div>
                         <div class="col-md-4">


                             <br>

                             <div class="mb-3" style="margin-left: 15px;">
                                 <img src="assets/images/img_fond.jpg" alt="avatar" id="img" width="200" height="200" required>
                                 <input type="file" name="foto" id="foto" accept="image/*" required>
                                 <label class="btn_img btn-primary" style="background-color:#f05941; border-color: #f05941;" for="foto">AGREGAR FOTO</label> <br>
                                 <span> (OBLIGATORIO) Tomar una foto al cliente , descargalo desde WhatsApp y cargar aquí</span>
                             </div>
                         </div>
                     </div>

                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                         <button type="submit" class="btn btn-primary" style="background-color:#f05941; border-color: #f05941;">REGISTRARSE</button>

                     </div>

                 </form>
             </div>

         </div>
     </div>
 </div>


 <!-- MODAL PARA ELIMINAR  -->
<div class="modal fade" id="DeleteModalOperario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">Eliminar Operario</h4>
            </div>
            <div class="modal-body">
                <form action="operario/D_operario.php" method="POST">
                    <input type="hidden" id="deleteOperarioId" name="Operario_id" value="">
                    ¿Estás seguro de que quieres eliminar este Operario?
                    <button class="btn btn-danger btn-circle">Eliminar</button>
                </form>
            </div>
        </div>
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

if (isset($_SESSION['deleted_cycle'])) {
    echo
    '<script>
    setTimeout(() => {
        Swal.fire({
            title: "¡Éxito!",
            text: "' . $_SESSION['deleted_cycle'] . '",
            icon: "success"
        });
    }, 500);
</script>';
    unset($_SESSION['deleted_cycle']);
}


if (isset($_SESSION['error_cycle'])) {
    echo
    '<script>
    setTimeout(() => {
        Swal.fire({
            title: "¡Error!",
            text: "' . $_SESSION['error_cycle'] . '",
            icon: "error"
        });
    }, 500);
    </script>';
    unset($_SESSION['error_cycle']);
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


 <?php
    require_once "inc/estructura/parte_inferior.php"
    ?>

    <!-- SCRIPT PARA ELIMINAR  -->
<script>
    $('#DeleteModalOperario').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Botón que activa el modal
        var cargoId = button.data('id'); // Extraer el ID del botón de eliminación
        var modal = $(this);
        modal.find('#deleteOperarioId').val(cargoId); // Actualizar el valor del input oculto con el ID
    });
</script>


 <script type="text/javascript">
     function cargar_info(dato) {

         document.getElementById('img2').src = "assets/images/operario/" + dato.dni + ".jpg";

         document.getElementById('u_id').value = dato.id;

         document.getElementById('u_nombre').value = dato.nombre;
         document.getElementById('u_apellido').value = dato.apellido;
         document.getElementById('u_telefono').value = dato.telefono;

         document.getElementById('u_edad').value = dato.edad;
         document.getElementById('u_estado').value = dato.estado;


         document.getElementById('u_turno').value = dato.turno;
         document.getElementById('u_cargo').value = dato.cargo;
         document.getElementById('u_dni').value = dato.dni;

         var generoSelect = document.getElementById('u_turno');

         for (var i = 0; i < generoSelect.options.length; i++) {
             if (generoSelect.options[i].value == dato.turno) {
                 generoSelect.options[i].selected = true;
                 break;
             }
         }

         var generoSelect2 = document.getElementById('u_cargo');

         for (var i = 0; i < generoSelect2.options.length; i++) {
             if (generoSelect2.options[i].value == dato.cargo) {
                 generoSelect2.options[i].selected = true;
                 break;
             }
         }




     }


     let table = new DataTable('#table_Operario', {
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
                 text: '<i class="fas fa-file-excel"></i> ',
                 titleAttr: 'Exportar a Excel'

             },
             {
                 extend: 'pdfHtml5',
                 text: '<i class="fas fa-file-pdf"></i> ',
                 titleAttr: 'Exportar a PDF',
                 orientation: 'landscape'
             },
             {
                 extend: 'print',
                 text: '<i class="fa fa-print"></i> ',
                 titleAttr: 'Imprimir'
             },
         ]

     });
 </script>

 <script src="assets/js/img.js"></script>
 <script src="assets/img2.js"></script>

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
 </style>