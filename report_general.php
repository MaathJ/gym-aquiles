<?php
include_once("auth.php");
include_once("inc/estructura/parte_superior.php");
include('config/dbconnect.php');

$start_of_year = date('Y-01-01');

$sqltabla = "SELECT 
            DATE_FORMAT(date_series.Date, '%y-%m-%d') AS Fecha,
            GROUP_CONCAT(CONCAT(TiposPagos, ': ', IFNULL(TotalIngreso, 0)) SEPARATOR ', ') AS TiposPagos,
            SUM(IFNULL(TotalIngreso, 0)) AS TotalIngreso
            FROM (
            SELECT CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS Date
            FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL 
                SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 
                UNION ALL SELECT 9) AS a
                CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 
                            UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 
                            UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
                CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 
                            UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 
                            UNION ALL SELECT 8 UNION ALL SELECT 9) AS c
            ) AS date_series
            LEFT JOIN (
                SELECT 
                    DATE(fecha) AS Fecha,
                    TiposPagos,
                    SUM(IngresosPorTipo) AS TotalIngreso
                FROM (
                    SELECT 
                        fecha,
                        TiposPagos,
                        SUM(IngresosPorTipo) AS IngresosPorTipo
                    FROM (
                        SELECT 
                            ap.fech_asip AS fecha,
                            tp.desc_tp AS TiposPagos,
                            SUM(tr.precio_tiru) AS IngresosPorTipo
                        FROM 
                            tipo_pago tp 
                        INNER JOIN 
                            asistencia_pago ap ON tp.id_tp = ap.id_tp 
                        INNER JOIN  
                            tipo_rutina tr ON ap.id_tiru = tr.id_tiru
                        WHERE 
                            DATE(ap.fech_asip) BETWEEN '$start_of_year' AND CURDATE()
                        GROUP BY 
                            fecha, tp.desc_tp

                        UNION ALL

                        SELECT 
                            ma.fecharegistro_ma AS fecha,
                            tp.desc_tp AS TiposPagos,
                            SUM(men.precio_me) AS IngresosPorTipo
                        FROM 
                            tipo_pago tp 
                        INNER JOIN 
                            matricula ma ON ma.id_tp = tp.id_tp 
                        INNER JOIN  
                            membresia men ON ma.id_me = men.id_me
                        WHERE 
                            DATE(ma.fecharegistro_ma) BETWEEN '$start_of_year' AND CURDATE()
                        GROUP BY 
                            fecha, tp.desc_tp
                    ) AS combined
                    GROUP BY 
                        fecha, TiposPagos
                ) AS combined_final
                GROUP BY 
                    Fecha, TiposPagos
            ) AS combined_final ON date_series.Date = combined_final.Fecha
            GROUP BY 
                Fecha";


?>


<div class="app-body-main-content">
    <div>
        <p>Pages<span> / Reporte General</span></p>
        <h3>Reporte</h3>
    </div>
    <div class="main-content">
        <div class="row mb-2 mt-2" style="align-items: center; background-color:white; margin-left: 1rem; margin-right: 1rem; padding: 1rem; border-radius: 1rem;">
            <div class="col-2">
                <p class="text-small text-center">Desde :</p>
            </div>
            <div class="col-4">
                <input class="form-control" type="date" id="fechaInicio">
            </div>
            <div class="col-1">
                <p class="text-small text-center">Hasta:</p>
            </div>
            <div class="col-4">
                <input class="form-control" type="date" id="fechaFin">
            </div>
        </div>
        <div class="col-md-12" style="background-color: white; padding: 1rem; border-radius: 1rem;">
            <table class="table table-striped" id="tablareporte">
                <thead align="center" class="" style="color: #fff; background-color:#f05941;">
                    <tr>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Formas de pago</th>
                        <th class="text-center">Total Ingreso</th>
                    </tr>
                </thead>
                <tbody align="center">
                    <?php
                    $fsqltabla = mysqli_query($cn, $sqltabla);

                    while ($rsqltabla = mysqli_fetch_assoc($fsqltabla)) {
                        if ($rsqltabla['TiposPagos'] != null) {
                    ?>
                            <tr>
                                <td><?php echo date('d-m-Y', strtotime($rsqltabla['Fecha'])); ?></td>
                                <td>
                                    <?php
                                    // Inicializar un array para almacenar los montos por tipo de pago
                                    $montos_por_tipo = array();

                                    // Separar tipos de pagos por comas
                                    $tipos_pagos = explode(", ", $rsqltabla['TiposPagos']);

                                    // Recorrer los tipos de pagos y sumar los montos
                                    foreach ($tipos_pagos as $tipo_pago) {
                                        // Separar el tipo de pago y el monto
                                        $tipo_monto = explode(": ", $tipo_pago);
                                        if (isset($tipo_monto[1]) && trim($tipo_monto[1]) !== null) {
                                            // Obtener el tipo de pago y el monto
                                            $tipo = trim($tipo_monto[0]);
                                            $monto = floatval(trim($tipo_monto[1]) == null || '' ? '' : floatval(trim($tipo_monto[1])));

                                            // Sumar el monto al tipo de pago correspondiente
                                            $montos_por_tipo[$tipo] = isset($montos_por_tipo[$tipo]) ? $montos_por_tipo[$tipo] + $monto : $monto;
                                        }
                                    }

                                    // Si hay tipos de pago ausentes, establecer su monto como 0
                                    foreach ($montos_por_tipo as $tipo => $monto) {
                                        if (!isset($montos_por_tipo[$tipo])) {
                                            $montos_por_tipo[$tipo] = 0;
                                        }
                                    }

                                    // Imprimir los tipos de pagos y las sumas correspondientes
                                    foreach ($montos_por_tipo as $tipo => $monto) {
                                        echo $tipo . ': ' . $monto . "<br>";
                                    }
                                    ?>
                                </td>
                                <td><?php echo 'S/' . $rsqltabla['TotalIngreso']; ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include_once("inc/estructura/parte_inferior.php")
?>



<script>
    $(document).ready(function() {
        function formatFecha(fechaTexto) {
            const parts = fechaTexto.split('-');
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }

        const inputsDate = $('input[type="date"]');

        // Agregar el evento change a los inputs
        inputsDate.change(function() {
            const table = document.getElementById('tablareporte');
            const tbody = table.querySelector('tbody');

            // Obtener los valores de los inputs
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFin = document.getElementById('fechaFin').value;

            // Validar que ambos valores no sean nulos ni vacíos
            if (fechaInicio === '' || fechaFin === '') {
                return;
            }

            // Convertir las fechas a objetos Date y obtener sus timestamps
            const rangoInicio = new Date(fechaInicio).getTime();
            const rangoFin = new Date(fechaFin).getTime();

            // Ocultar todas las filas por defecto
            const filas = Array.from(tbody.querySelectorAll('tr'));
            filas.forEach(fila => fila.style.display = 'none');

            // Recorrer las filas y mostrar las que están dentro del rango
            filas.forEach(fila => {
                const fechaCelda = fila.querySelector('td:first-child');
                const fecha = new Date(formatFecha(fechaCelda.textContent)).getTime();

                if (fecha >= rangoInicio && fecha <= rangoFin) {
                    fila.style.display = '';
                }
            });
        });
    });


    let table = new DataTable('#tablareporte', {
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