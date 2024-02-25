<?php
include_once('auth.php');
include_once("inc/estructura/parte_superior.php");
include_once('config/dbconnect.php');
?>
<link rel="stylesheet" src="style.css" href="assets/css/membresia/membresia.css">

<div class="app-body-main-content">
    <div>
        <p>Pages<span> / Membresia</span></p>
        <h3>Membresia</h3>
    </div>
    <div class="main-content">
        <div>
            <button class="membresia" data-toggle="modal" data-target="#R_memb">
            Nuevo Membresia
            </button>
        </div>
        <div class="row">


                    <!-- PRUEBA CARDS -->
                    <div class="card-columns">
                        <?php
                        $cn = mysqli_connect("localhost", "root", "", "bd_gym2023");

                        $sql = "SELECT m.*, s.nombre_se FROM membresia m LEFT JOIN servicio s ON m.id_se=s.id_se";

                        $f = mysqli_query($cn, $sql);
                        while ($r = mysqli_fetch_assoc($f)) {
                        ?>
                            <div class="card" align="center">
                                <div class="card-body">
                                    <h2 class="card-title">
                                        <?php echo $r['nombre_me']; ?>
                                    </h2>
                                    <h3 class="card-subtitle mb-2 text-muted">
                                        <?php echo $r['nombre_se']; ?>
                                    </h3>
                                    <h3 class="card-subtitle mb-2 text-muted">
                                        <?php
                                        if ($r['duracion_me'] == 1) {
                                            echo $r['duracion_me'] . " mes";
                                        } else {
                                            echo $r['duracion_me'] . " meses";
                                        }
                                        ?>
                                    </h3>
                                    <h4 class="<?php echo ($r['estado_me'] == 'ACTIVO') ? 'tdactivo' : 'tdculminado'; ?>">
                                        <p><?php echo $r['estado_me']; ?></p>
                                    </h4>
                                    <h2 class="card-title">
                                        S/. <?php echo $r['precio_me']; ?>
                                    </h2>

                                </div>
                                <div class="card-footer">
                                    <!-- BOTON INSCRIBIR -->
                                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#"> INSCRIBIR </button> -->

                                    <!-- BOTON EDITAR -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#U_membresia" onclick="cargar_info({ 
                                        'id_me': '<?php echo $r['id_me']; ?>',
                                        'nombre_me': '<?php echo $r['nombre_me']; ?>',
                                        'duracion_me': '<?php echo $r['duracion_me']; ?>',
                                        'precio_me': '<?php echo $r['precio_me']; ?>',
                                        'estado_me': '<?php echo $r['estado_me']; ?>',
                                        'servicio_me': '<?php echo $r['id_se']; ?>'
                                    });"> EDITAR </button>

                                    <!-- BOTON ELIMINAR -->
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#D_membresia" onclick="cargar_info_label({ 
                                        'id_me': '<?php echo $r['id_me']; ?>',
                                        'nombre_me': '<?php echo $r['nombre_me']; ?>',
                                        'duracion_me': '<?php echo $r['duracion_me']; ?>',
                                        'precio_me': '<?php echo $r['precio_me']; ?>',
                                        'estado_me': '<?php echo $r['estado_me']; ?>',
                                        'id_se': '<?php echo $r['nombre_se']; ?>'
                                    });"> ELIMINAR </button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- FIN -->
                    <hr>
                    <!-- BOTON AGREGAR -->

                    <!-- MODAL PARA REGISTRO  -->
                    <div class="modal fade" id="R_memb" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header " style="background-color: #F39C12; color: #ffffff;">
                                    <h4 class="modal-title" id="exampleModalLabel">REGISTRAR MEMBRESIA</h4>
                                    <button type="button" class="btn-close" style="background-color: #ffffff;" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="membresia/R_membresia.php" method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="recipient_name" class="col-form-label" style="color: black;">Nombre:</label>
                                                    <input type="text" name="txt_nomb" class="form-control" id="recipient_name" required maxlength="30">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient_duracion" class="col-form-label" style="color: black;">Duración (mes):</label>
                                                    <input type="number" name="txt_dura" class="form-control" id="recipient_duracion" step="1" required>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="recipient_precio" class="col-form-label" style="color: black;">Precio:</label>
                                                    <input type="number" name="txt_prec" class="form-control" id="recipient_precio" step="0.01" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient_servicio" class="col-form-label" style="color: black;">Servicio:</label>
                                                    <select class="form-select form-select-lg mb-3" name="lst_serv" id="recipient_servicio" required>
                                                        <?php

                                                        $cn = mysqli_connect("localhost", "root", "", "bd_gym2023");

                                                        $sql_lst = "select * from servicio";

                                                        $f_lst = mysqli_query($cn, $sql_lst);

                                                        while ($r_lst = mysqli_fetch_assoc($f_lst)) {
                                                        ?>
                                                            <option value="<?php echo $r_lst["id_se"] ?>"><?php echo utf8_encode($r_lst["nombre_se"]) ?> </option>
                                                        <?php } ?>
                                                    </select>
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

                    <!-- MODAL PARA EDITAR  -->
                    <div class="modal fade" id="U_membresia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header " style="background-color: #F39C12; color: #ffffff;">
                                    <h4 class="modal-title" id="exampleModalLabel">EDITAR MEMBRESIA</h4>
                                    <button type="button" class="btn-close" style="background-color: #ffffff;" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="membresia/U_membresia.php" method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="txt_id" class="form-control" id="recipient-id" required value="" hidden>
                                                <div class="mb-3">
                                                    <label for="recipient_name" class="col-form-label" style="color: black;">Nombre:</label>
                                                    <input type="text" name="txt_nomb" class="form-control" id="recipient-name" required maxlength="30" value="">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient_duracion" class="col-form-label" style="color: black;">Duración (mes):</label>
                                                    <input type="number" name="txt_dura" class="form-control" id="recipient-duracion" step="1" required value="<?php echo $r['duracion_me']; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient_precio" class="col-form-label" style="color: black;">Precio:</label>
                                                    <input type="number" name="txt_prec" class="form-control" id="recipient-precio" step="0.01" required value="">
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="recipient_estado" class="col-form-label" style="color: black;">Estado:</label>
                                                    <select class="form-select form-select-lg mb-3" name="lstestado" id="recipient-estado" required>
                                                        <option value="ACTIVO">ACTIVO</option>
                                                        <option value="INACTIVO">INACTIVO</option>
                                                    </select>

                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient_servicio" class="col-form-label" style="color: black;">Servicio:</label>

                                                    <select class="form-select form-select-lg mb-3" name="lst_serv" id="recipient-servicio" required>
                                                        <option value="" disabled selected>Selecciona un servicio</option>
                                                        <?php

                                                        $cn = mysqli_connect("localhost", "root", "", "bd_gym2023");

                                                        $sql_lst = "select * from servicio";

                                                        $f_lst = mysqli_query($cn, $sql_lst);

                                                        while ($r_lst = mysqli_fetch_assoc($f_lst)) {
                                                        ?>
                                                            <option value="<?php echo $r_lst['id_se'] ?>">
                                                                <?php echo utf8_encode($r_lst["nombre_se"]); ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                                            <button type="submit" class="btn btn-primary">EDITAR</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL PARA ELIMINAR  -->
                    <div class="modal fade" id="D_membresia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header " style="background-color: #EC7063; color: #ffffff;">
                                    <h4 class="modal-title" id="exampleModalLabel">¡ADVERTENCIA! SE ELIMINARÁ LA SIGUIENTE MEMBRESÍA</h4>
                                    <button type="button" class="btn-close" style="background-color: #ffffff;" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="membresia/D_membresia.php" method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <input type="text" name="txt_id" class="form-control" id="label_id" required hidden>
                                                    ¿Seguro que desea eliminar la membresía seleccionada?
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                            <button type="submit" class="btn btn-danger">CONFIRMAR</button>
                                        </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>



<?php
include_once("inc/estructura/parte_inferior.php")
?>

<script type="text/javascript">
            function cargar_info(dato) {
        document.getElementById('recipient-id').value = dato.id_me;
        document.getElementById('recipient-name').value = dato.nombre_me;
        document.getElementById('recipient-duracion').value = dato.duracion_me;
        document.getElementById('recipient-precio').value = dato.precio_me;
        document.getElementById('recipient-estado').value = dato.estado_me;
        document.getElementById('recipient-servicio').value = dato.servicio_me;
    }

    function cargar_info_label(dato) {
        document.getElementById('label_id').value = dato.id_me;
        document.getElementById('label_name').value = dato.nombre_me;
        document.getElementById('label_duracion').value = dato.duracion_me;
        document.getElementById('label_precio').value = dato.precio_me;
        document.getElementById('label_estado').value = dato.estado_me;
        document.getElementById('label_servicio').value = dato.id_se;
    }

      

</script>
