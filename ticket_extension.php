<!-- CONTIENE LOS DATOS PARA EL MODAL Y SCRIPT PDF -->

<!-- MODAL PARA PDF -->
<div class="modal fade  " id="pdfModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content text-center">
            <div class="modal-header " style="background-color: orange; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">IMPRIMIR TICKET</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdfIFrame" width="900" height="600"></iframe>
            </div>
        </div>
    </div>
    <!-- Page-body end -->
</div>

<script>
    function pdf_cod(cod, dest){
        document.getElementById("pdfIFrame").src= "ticket.php?cod=" + cod + "&dest=" + dest;
    }
</script>