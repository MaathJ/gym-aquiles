 <?php
include('./config/dbconnect.php');
include_once('auth.php');
require_once "inc/estructura/parte_superior.php"

?>

<!-- Page-header end -->
<div class="pcoded-inner-content" style="background-color: #fff;">
    <!-- Main-body start -->
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page-body start -->
            <div class="page-body">
                <div class="row">

                    <div class="container"> 
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-lg " style="background: #17a2b8;" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                                        <i class="fa-solid fa-plus text-white"></i> <span class="text-white">Nuevo Operario</span>
                                    </button>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>

                            </div>
                        </div>
                        <br>

                        <div class="col-md-12">
                            <table class="table table-striped table_id"  id="table_cliente">

                                <thead align="center" class=""  style="color: #fff; background-color:#17a2b8;">
                                    <tr align="center">
                                        <th> ID </th>
                                        <th> FOTO </th>
                                        <th> OPERARIO</th>
                                        <th> DNI </th>
                                        <th> Telefono </th>
                                        <th> Edad </th>
                                        <th> Estado</th>
                                        <th> F.Registro</th>
                                        <th> Turno</th>
                                        <th> Cargo</th>
                                        <th> Opciones</th>
                                    </tr>
                                </thead>
                                <?php
                                $sql = "SELECT * from operario op inner join cargo cr on op.id_ca=cr.id_ca inner join turno tr on op.id_tu = tr.id_tu ";
                                $f = mysqli_query($cn, $sql);
                                while ($r = mysqli_fetch_assoc($f)) {
		

                                ?>
                                    <td align="center"><?php echo $r['id_op'] ?></td>
                                    <td align="center"><img src="assets/images/operario/<?php echo $r['dni_op'] ?>.jpg" width="65px" style="border-radius: 20px;"  height="65px"></td>
                                    <td align="center"><?php echo $r['nombre_op']. ' ' . $r['apellido_op']  ?></td>
                                  
                                    <td align="center"><?php echo $r['dni_op'] ?></td>
                                    <td align="center"><?php echo $r['telefono_op'] ?></td>
                                    <td align="center"><?php echo $r['edad_op'] ?></td>
                                    <td align="center"><?php echo $r['estado_op'] ?></td>
                                    <td align="center"><?php echo $r['fecharegistro_op'] ?></td>
                                    <td align="center"><?php echo $r['nombre_tu'] ?></td>
                                    <td align="center"><?php echo $r['nombre_ca'] ?></td>
                                    <td>
                                        <center>

                                            <a class="btn btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#exampleModalEditar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
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


                                         <a href="operario/D_operario.php?d=<?php echo $r['id_op'] ?>" class="btn btn-danger btn-circle " target="_parent">
                                                <i class="fas fa-trash"> </i></a>
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

<div class="modal fade  " id="exampleModalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #0B5ED7; color: #ffffff;">
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
                                    <input type="text"  name="txtnombre" class="form-control" id="u_nombre" placeholder="nombres completo" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Apellido-name" class="col-form-label" style="color: black;">Apellido:</label>
                                    <input type="text" name="txtapellido" class="form-control" id="u_apellido" placeholder="apellidos completo" required>
                                </div>

                                <div class="mb-3">
                                    <label for="Dni-name" class="col-form-label" style="color: black;">Dni:</label>
                                  <input type="number" name="txtdni" class="form-control" id="u_dni"   oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" placeholder="DNI o Cedula" required>

                                </div>


                                <div class="mb-3">
                                    <label for="Telefono-name" class="col-form-label" style="color: black;">Teléfono:</label>
                                    <input type="number" name="txttelefono" class="form-control"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="ingrese 9 digitos" maxlength="9"id="u_telefono" required>
                                </div>

                            </div>

                            <div class="col-md-4">


                                 <div class="mb-3">
                                    <label for="Edad-name" class="col-form-label" style="color: black;">Estado:</label>

                                    <select name="lstestado" id="u_estado">
                                        <option value=""  selected>Selecciona un estado</option>
                                        
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
                                    <select name="lstcargo" id="u_cargo" class="form-select form-select-sm mb-3" >
                                        
                                        <?php 

                                        $sqlUca = "SELECT * FROM cargo WHERE estado_ca ='ACTIVO' ";
                                         $fUca=  mysqli_query($cn,$sqlUca);

                                         while ($rUca=mysqli_fetch_assoc($fUca)) {
                                           
                                        
                                        
                                        ?>
                                        <option value="<?php echo $rUca['id_ca']?>"><?php echo $rUca['nombre_ca']?></option>
                                  
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
                                         $ftu=  mysqli_query($cn,$sqlTu);

                                         while ($rt=mysqli_fetch_assoc($ftu)) {
                                           
                                        
                                        
                                        ?>
                                        <option value="<?php echo $rt['id_tu']?>"><?php echo $rt['nombre_tu']?></option>
                                  
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
                                    <label class="btn_img btn-primary" for="foto2">CAMBIAR FOTO</label>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                            <button type="submit" class="btn btn-primary">Modificar</button>
                            <input type="hidden" name="cod" id="u_id" >
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
                <div class="modal-header " style="background-color: #0B5ED7; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">REGISTRO OPERARIO</h4>
                                
                     
                    <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
                    <br>
                 
                </div>
                <span>Es importante Completar todos los campos</span>
                <div class="modal-body">


                    <form action="operario/R_operario.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="Nombre-name" class="col-form-label" style="color: black;">Nombre:</label>
                                    <input type="text"  name="txtnombre" class="form-control" id="Nombre-name" placeholder="nombres completo" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Apellido-name" class="col-form-label" style="color: black;">Apellido:</label>
                                    <input type="text" name="txtapellido" class="form-control" id="Apellido-name" placeholder="apellidos completo" required>
                                </div>

                                <div class="mb-3">
                                    <label for="Dni-name" class="col-form-label" style="color: black;">Dni:</label>
                                  <input type="number" name="txtdni" class="form-control" id="Dni-name"   oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" placeholder="DNI o Cedula" required>

                                </div>


                                <div class="mb-3">
                                    <label for="Telefono-name" class="col-form-label" style="color: black;">Teléfono:</label>
                                    <input type="number" name="txttelefono" class="form-control"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="ingrese 9 digitos" maxlength="9"id="Telefono-name" required>
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
                                         $f=  mysqli_query($cn,$sql);

                                         while ($r=mysqli_fetch_assoc($f)) {
                                           
                                        
                                        
                                        ?>
                                        <option value="<?php echo $r['id_ca']?>"><?php echo $r['nombre_ca']?></option>
                                  
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
                                         $ftu=  mysqli_query($cn,$sqlTu);

                                         while ($rt=mysqli_fetch_assoc($ftu)) {
                                           
                                        
                                        
                                        ?>
                                        <option value="<?php echo $rt['id_tu']?>"><?php echo $rt['nombre_tu']?></option>
                                  
                                        <?php 
                                         }
                                        
                                        ?>
                                    </select>
                                </div> 

                               
                            </div>
                            <div class="col-md-4">
                                
 
                                <br>

                                <div class="mb-3" style="margin-left: 15px;">
                                    <img src="assets/images/img_fond.jpg" alt="avatar" id="img" width="200" height="200"required>
                                    <input type="file" name="foto" id="foto" accept="image/*" required>
                                    <label class="btn_img btn-primary" for="foto">AGREGAR FOTO</label> <br>
                                    <span> (OBLIGATORIO) Tomar una foto al cliente , descargalo desde WhatsApp y cargar aquí</span>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                            <button type="submit" class="btn btn-primary">REGISTRARSE</button>
                          
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>






<?php
require_once "inc/estructura/parte_inferior.php"
?>
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
				text:      '<i class="fas fa-file-excel"></i> ',
				titleAttr: 'Exportar a Excel',
				className: 'btn btn-success'
			},
			{
				extend:    'pdfHtml5',
				text:      '<i class="fas fa-file-pdf"></i> ',
				titleAttr: 'Exportar a PDF',
				className: 'btn btn-danger',
                orientation: 'landscape' 
			},
			{
				extend:    'print',
				text:      '<i class="fa fa-print"></i> ',
				titleAttr: 'Imprimir',
				className: 'btn btn-info'
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