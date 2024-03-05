<?php
include_once("auth.php");
include_once("inc/estructura/parte_superior.php");
include('config/dbconnect.php');



$sqltabla="SELECT 

CURDATE() AS Fecha,
GROUP_CONCAT(tp.desc_tp) AS TiposPagos,
GROUP_CONCAT(tr.precio_tiru) AS IngresosPorTipo,
(
    SELECT SUM(tr2.precio_tiru) 
    FROM tipo_pago tp2 
    INNER JOIN asistencia_pago ap2 ON tp2.id_tp = ap2.id_tp 
    INNER JOIN tipo_rutina tr2 ON ap2.id_tiru = tr2.id_tiru
    WHERE DATE(ap2.fech_asip) = CURDATE()
) AS TotalIngreso
FROM 
tipo_pago tp 
INNER JOIN 
asistencia_pago ap ON tp.id_tp = ap.id_tp 
INNER JOIN  
tipo_rutina tr ON ap.id_tiru = tr.id_tiru
WHERE 
DATE(ap.fech_asip) = CURDATE()
GROUP BY 
CURDATE()


            ";
?>


<div class="app-body-main-content">
    <div>
        <p>Pages<span> / Reporte General</span></p>
        <h3>Reporte</h3>
    </div>
    <div class="main-content">
        <div>
            
        </div>
        <div class="col-md-12" style="background-color: white; padding: 1rem; border-radius: 1rem;">
            <table class="table table-striped" id="table_rol">
                <thead align="center" class="" style="color: #fff; background-color:#f05941;">
                    <tr>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Formas de pago</th>
                        <th class="text-center">Total Ingreso</th>
                    </tr>
                </thead>
                <tbody align="center">
                <?php 
                $fsqltabla=mysqli_query($cn,$sqltabla);
                                    
                while($rsqltabla=mysqli_fetch_assoc($fsqltabla)){
                    ?>
                    <tr>
                        <td><?php echo $rsqltabla['Fecha']; ?></td>
                        <td>
                            <?php 
                            // Separar tipos de pagos y montos
                            $tipos_pagos = explode(",", $rsqltabla['TiposPagos']);
                            $montos_pagos = explode(",", $rsqltabla['IngresosPorTipo']);
                            
                            // Imprimir tipos de pagos y montos
                            foreach($tipos_pagos as $key => $tipo_pago) {
                                echo $tipo_pago . ": " . $montos_pagos[$key] . "<br>";
                            }
                            ?>
                        </td>
                        <td><?php echo $rsqltabla['TotalIngreso']; ?></td>
                    </tr>
                    <?php
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