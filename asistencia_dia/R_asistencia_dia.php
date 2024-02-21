<?php  

include('../conexion.php');

if(isset($_POST['txt_nombre']) && isset($_POST['lst_rutina']) && isset($_POST['lst_tp'])){
    $nom =$_POST['txt_nombre'];
    $rut =$_POST['lst_rutina'];
    $tp = $_POST['lst_tp'];

    $sql = "insert into asistencia_pago(nomb_asip, id_tiru, id_tp) 
    values ('$nom', '$rut', '$tp')";

    $r = mysqli_query($cn, $sql);

    $id = mysqli_insert_id($cn);
    $dest="'a_dia'";

    $sql="select ap.fech_asip as fecha,
        tp.desc_tp as nombre_tp,
        tr.nombre_tiru as nombre_tr
        from asistencia_pago ap
        inner join tipo_rutina tr on ap.id_tiru = tr.id_tiru
        inner join tipo_pago tp on ap.id_tp = tp.id_tp
        where id_asip=$id";
    $f=mysqli_query($cn,$sql);
    $r=mysqli_fetch_assoc($f);

    $tiempo = new Datetime($r['fecha']);
    $fecha = $tiempo->format('H:i d-m-Y');

    $nom_tp = $r['nombre_tp'];
    $nom_tr = $r['nombre_tr'];
    
    echo '<div class="matri-content">
            <div class="matri-content-info">
                <p>' . $nom . '</p>
                <p><span>Rutina: </span>' . $nom_tr . '</p>
                <p><span>Tipo pago: </span>' . $nom_tp . '</p>
                <p><span>Fecha de registro:</span>' . $fecha . '</p>
            </div>
            <div align="center">
                <a class="btn btn-sm btn-success btn-circle text-white" data-bs-toggle="modal" data-bs-target="#pdfModal" data-bs-whatever="@mdo" onclick="pdf_cod(' . $id . ', '.$dest.')">
                    <i class="fas fa-print"></i> IMPRIMIR
                </a>
            </div>
            
        </div>';
}else{
    echo "";
}
?>