<?php
include_once('auth.php');
include_once("inc/estructura/parte_superior.php");
include_once('config/dbconnect.php');
?>

<link rel="stylesheet" src="style.css" href="assets/css/matricula/matricula.css">
<div class="app-body-main-content">
    <div>
        <p>Aquiles<span> / Cargo</span></p>
        <h3>Cargo</h3>
    </div>
    <div class="main-content">
        <div>
            <button class="matricula" data-bs-toggle="modal" data-bs-target="#ModalRegistroCargo" data-bs-whatever="@mdo">
                Nuevo Cargo
            </button>
        </div>

                        <div class="col-md-12">
                            <table class="table table-striped" id="table_rol">
                                <thead align="center" class="" style="color: #fff; background-color:#f05941;">
                                    <tr>
                                        <th>ID</th>
                                        <th>CARGO</th>
                                        <th>ESTADO</th>
                                        <th>OPCIONES</th>
                                    </tr>


                                </thead>
                                <tbody>
                                    <?php

                                    $sql = "SELECT * FROM cargo ";
                                    $f = mysqli_query($cn, $sql);
                                    while ($r = mysqli_fetch_assoc($f)) {

                                    ?>

                                        <tr>
                                            <td align="center"><?php echo $r['id_ca'] ?></td>
                                          
                                            <td align="center"><?php echo $r['nombre_ca'] ?></td>
                                            <td align="center"><?php echo $r['estado_ca'] ?></td>
                                            <td align="center">
                                                <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#Modalcargoupdate" data-bs-whatever="@mdo" target="_parent" onclick=" cargar_info({
                                                'id':' <?php echo $r['id_ca'] ?? ''; ?> ',
                                                'nombre':'<?php echo $r['nombre_ca'] ?? ''; ?>',
                                                'estado':'<?php echo $r['estado_ca'] ?? ''; ?>'
                                            } )">
                                                    <i class="fas fa-edit"> </i></a>



                                                <a href="cargo/D_cargo.php?cod=<?php echo $r['id_ca'] ?>" class="btn btn-sm btn-danger" target="_parent"><i class="fas fa-trash"> </i></a>
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
            </div>
            <!-- Page-body end -->
        </div>
        <div id="styleSelector"> </div>
    </div>
</div>



<!-- MODAL PARA EDITAR ROLES  -->
<div class="modal fade  " id="Modalcargoupdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR CARGO:</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <form action="cargo/U_cargo.php" method="post">
                    <div class="row">
                    <div class="col-12 mb-3">
                                <label for="rol" class="col-form-label" style="color: black;">CARGO:</label>
                                <input type="text" name="u_cargo" placeholder="Ingrese el cargo" class="form-control" id="u_cargo" required>
                            
                                <label for="estado" class="col-form-label" style="color: black;">ESTADO:</label>
                                <select class="form-control" name="u_estado" id="u_estado">
                                    <option  value="ACTIVO">ACTIVO</option>
                                    <option  value="INACTIVO">INACTIVO</option>     
                                                                  
                                </select>

                        </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="" style="background-color:#f05941; border-color: #f05941;">MODIFICAR</button>
                        <input type="hidden" name="u_cod" id="u_cod" >

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Page-body end -->
</div>

<!-- MODAL PARA REGISTRO cargos  -->
<div class="modal fade  " id="ModalRegistroCargo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #f05941; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">REGISTRO DE CARGO:</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <form action="cargo.php" method="get">
                    <div class="row">
                    <div class="col-12 mb-3">
                                <label for="rol" class="col-form-label" style="color: black;">CARGO:</label>
                                <input type="text" name="cargo" placeholder="Ingrese el cargo" class="form-control" id="cargo" required>
                            </div>


                        </div>

                        <div class="col-md-6">
                            <!-- <div class="mb-3">
                                <label for="estado" class="col-form-label" style="color: black;">ESTADO:</label>
                                <select class="form-control" name="" id="">
                                    <option value=""></option>
                                    <option value=""></option>
                                    <option value=""></option>

                                </select>

                            </div> -->

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="registrar" style="background-color:#f05941; border-color: #f05941;">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Page-body end -->
</div>
<?php
require_once ("inc/estructura/parte_inferior.php");

?>
<script>
    function cargar_info(dato) {

        document.getElementById('u_cod').value = dato.id;
        document.getElementById('u_cargo').value = dato.nombre;

        document.getElementById('u_estado').value = dato.estado;

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
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> ',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                orientation: 'landscape'
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-info'
            },
        ]

    });
</script>

<?php

if (isset($_GET['cargo'])) {

    $cargo = strtoupper($_GET['cargo'] );
    $estado = 'ACTIVO';


    $sqlcargo = "INSERT INTO cargo (nombre_ca,estado_ca) VALUES('$cargo','$estado')";
    mysqli_query($cn, $sqlcargo);

    echo '<script>window.location.href = "cargo.php";</script>';

}

?>



