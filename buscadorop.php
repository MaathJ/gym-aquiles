<?php

include_once('config/dbconnect.php');

if ($cn->connect_error) {
    die("Error de conexión a la base de datos: " . $cn->connect_error);
}

if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];

    $sql = "SELECT * FROM operario WHERE estado_op = 'ACTIVO' AND dni_op = '$searchTerm'";
    $result = $cn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $codop = $row['id_op'];

        $sqlCheckAsistencia = "SELECT COUNT(*) AS count FROM asistenciaop WHERE id_op = $codop AND DATE(fecha_aop) = CURDATE()";
        $resultCheckAsistencia = $cn->query($sqlCheckAsistencia);
        $countAsistencia = $resultCheckAsistencia->fetch_assoc()['count'];

        // Determinar el estado dependiendo si el número de registros es par o impar
        $estado = ($countAsistencia % 2 == 0) ? 'INGRESO' : 'SALIDA';

        $sqlAsistencia = "INSERT INTO asistenciaop (id_op, estado_aop) VALUES ($codop, '$estado')";
        if ($cn->query($sqlAsistencia)) {
            $operadorInfo = array(
                'nombre' => $row['nombre_op'],
                'apellido' => $row['apellido_op'],
                'dni' => $row['dni_op'],
                'estado' => $estado,
                'fechaHora' => date('d/m/Y h:i A')
            );
            echo json_encode($operadorInfo);
        } else {
            echo json_encode(array('error' => 'Error al insertar registro de asistencia'));
        }
    } else {
        echo json_encode(array('error' => 'Operador no encontrado'));
    }

    $cn->close();
}
?>