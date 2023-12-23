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
        <h3>Rutina</h3>
    </div>
    <div class="main-content">
        <div>
            <button class="rutina" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
            Nuevo Rutina
            </button>
        </div>
        <div class="col-md-12">
                            <table class="table table-striped"  id="table_tiporutina">

                                <thead align="center" class=""  style="color: #fff; background-color:#f05941;">
                                    <tr >
                                        <th> CODIGO </th>
                                        <th> NOMBRE </th>
                                        <th> PRECIO </th>
                                        <th> OPCIONES</th>
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

                                            <a class="btn btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#exampleModal2" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                                                'id': '<?php echo $r['id_tiru'] ?? ''; ?>',
                                                'nombre': '<?php echo $r['nombre_tiru'] ?? ''; ?>',
                                                'precio': '<?php echo $r['precio_tiru'] ?? ''; ?>'
                                            });">
                                                <i class="fas fa-edit"> </i></a>


                                            <a href="tipo_rutina/D_tipo_rutina.php?d=<?php echo $r['id_tiru'] ?>" class="btn btn-danger btn-circle " target="_parent">
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
                                    <h4 class="modal-title" id="exampleModalLabel">REGISTRAR NUEVO SERVICIO</h4>
                                    <button type="button" class="btn-close" style="background-color: #ffffff;" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="membresia/R_servicio.php" method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label" style="color: black;">Nombre:</label>
                                                    <input type="text" name="txt_nomb" class="form-control" id="recipient-name" required>
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




<?php
include_once("inc/estructura/parte_inferior.php")
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
                    "sLast":"Último",
                    "sNext":"Siguiente",
                    "sPrevious": "Anterior"
			     },
			     "sProcessing":"Procesando...",
            }   ,
        //para usar los botones   
        responsive: "true",
        dom: 'Bfrtilp',       
        buttons:[ 
			{
				extend:    'excelHtml5',
				text:      '<i class="fa-regular fa-file-excel"></i> ',
				titleAttr: 'Exportar a Excel',
				// className: 'btn btn-success'
			},
			{
				extend:    'pdfHtml5',
				text:      '<i class="fa-regular fa-file-pdf"></i>',
				titleAttr: 'Exportar a PDF',
				// className: 'btn btn-danger',
                orientation: 'landscape' 
			},
			{
				extend:    'print',
				text:      '<i class="fa-solid fa-print"></i>',
				titleAttr: 'Imprimir',
				// className: 'btn btn-info'
			},
		]	      

});
</script>



