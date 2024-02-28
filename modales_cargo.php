<?php 

function deleteModalCargo($id)
{
    echo <<<HTML
    <div class="modal fade  " id="DeleteModalCargo{$id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #010133; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">Registro Periodo Academico</h4>
                </div>
                <div class="modal-body">
                    <form action="app/controllers/periodo/D_periodo.php?id={$id}" method="POST">
                        ¿Estas seguro de que quieres eliminar este periodo?
                        <button class="btn btn-danger btn-circle">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
HTML;
}


?>