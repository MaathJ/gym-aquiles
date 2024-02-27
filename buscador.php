<?php
include_once('auth.php');
include('config/dbconnect.php');

if ($cn->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];

    // Consulta SQL para buscar en la tabla cliente por nombre_cli
    $sql = "SELECT cli.*, ma.*, me.*, se.* FROM cliente cli 
            INNER JOIN matricula ma ON cli.id_cli = ma.id_cli 
            INNER JOIN membresia me ON ma.id_me = me.id_me 
            INNER JOIN servicio se ON me.id_se = se.id_se
            WHERE cli.dni_cli LIKE '%$searchTerm%' AND ma.estado_ma ='ACTIVO'";
    $result = $cn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $matricula = $row['id_ma'];
       
    
        // Verificar si ya existe un registro de asistencia para hoy
        $fechaHoy = date('Y-m-d');
        $sqlCheckAsistencia = "SELECT COUNT(*) as count FROM asistencia 
        WHERE id_ma = $matricula 
        AND DATE(fecha_as) = '$fechaHoy'";
        $resultCheckAsistencia = $cn->query($sqlCheckAsistencia);
        $countAsistencia = $resultCheckAsistencia->fetch_assoc()['count'];

        if ($countAsistencia == 0) {
            // Si no hay registro de asistencia para hoy, entonces inserta uno
            $sqlAsistencia = "INSERT INTO asistencia (id_ma) VALUES ($matricula)";
            $cn->query($sqlAsistencia);

            // Resto de tu código para construir el contenido HTML
            $fechaInicio = new DateTime();
            $fechaFin = new DateTime($row['fechafin_ma']);
            $diferencia = $fechaInicio->diff($fechaFin);
            $diasRestantes = $diferencia->days;
            echo '<div class="matriculados-info">
                    <div class="info-foto">
                        <img src="assets/images/cliente/' . $row['dni_cli'] . '.jpg' . '" alt="">
                    </div>
                    <div class="info-datos">
                        <h1>¡Bienvenido a Gym <span>Aquiles</span>!</h1>
                        <h2>' . $row['apellido_cli'] . ' ' . $row['nombre_cli'] . '</h2>
                        <h3>Te quedan '. $diasRestantes . ' días Restantes</h3>
    
                        
                    </div>

                    <div>
                        <a class="btn btn-sm btn-success btn-circle text-white" data-bs-toggle="modal" data-bs-target="#pdfModal" data-bs-whatever="@mdo" onclick="pdf_cod(' . $id . ', '. $desc .')">
                        <i class="fas fa-print"></i> IMPRIMIR
                        </a>
                    </div>  
                </div>';
        } else {
            // Si ya existe un registro de asistencia para hoy, muestra una alerta
            echo 'Ya ingresó hoy';
        }
    }

    // Cerrar la conexión a la base de datos
    $cn->close();
}
?>
