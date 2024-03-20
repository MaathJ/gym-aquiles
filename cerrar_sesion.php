<?php 
session_start();
session_destroy();

    include('config/dbconnect.php');

    $codigo = $_SESSION['codigo'];

    date_default_timezone_set('America/Lima');
                            $fechaHora = date("Y-m-d H:i:s");

    $sqldato = "select * from usuario us inner join caja cj on us.id_us = cj.id_us where us.id_us = '$codigo' and cier_caj is null";

    $fdato = mysqli_query($cn, $sqldato);
    $cant_usuario = mysqli_num_rows($fdato);

        if($cant_usuario > 0){
            $rdato = mysqli_fetch_assoc($fdato);
            $fecha_inicio = $rdato['aper_caj'];
            $s =  $rdato['sal_inicial'];
            $codigocaja = $rdato['id_caj'];
            $sql_dtp = "SELECT tp.desc_tp AS tipopago, 
                                           COALESCE(SUM(tpago.total), 0) AS total
                                    FROM tipo_pago tp
                                    LEFT JOIN (
                                        SELECT ap.id_tp, SUM(tr.precio_tiru) AS total
                                        FROM asistencia_pago ap
                                        INNER JOIN tipo_rutina tr ON ap.id_tiru = tr.id_tiru
                                        WHERE ap.fech_asip BETWEEN '$fecha_inicio' AND '$fechaHora'
                                        GROUP BY ap.id_tp

                                        UNION ALL

                                        SELECT ma.id_tp, SUM(men.precio_me) AS total
                                        FROM matricula ma
                                        INNER JOIN membresia men ON ma.id_me = men.id_me 
                                        WHERE ma.fecharegistro_ma BETWEEN '$fecha_inicio' AND '$fechaHora'
                                        GROUP BY ma.id_tp
                                    ) AS tpago ON tp.id_tp = tpago.id_tp
                                    GROUP BY tp.desc_tp;
                                        ";

            $f = mysqli_query($cn, $sql_dtp);
            while($r = mysqli_fetch_assoc($f)){
                $yape[] = $r['total'];    
            }
            $e = $yape[0];
            $y = $yape[1];
            $p = $yape[2];

            $t = $e+$y+$p+$s;


            $sqlcierre = "UPDATE caja SET cier_caj = '$fechaHora', yape_caj= '$y' , plin_caj = '$p' , ejec_caj = '$e' , tot_caj = '$t' WHERE id_caj = $codigocaja"; 

            mysqli_query($cn, $sqlcierre);
        }
header("location: index.php")
 ?>