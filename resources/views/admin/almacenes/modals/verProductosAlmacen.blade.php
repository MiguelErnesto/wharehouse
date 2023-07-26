<!-- Modal para ver Productos del Almacen -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 id='titleMdVerProdAlm' class="modal-title">Productos del Almacén</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <table id="Head">
                </table>

                <input type="hidden" id="almacen_id">

                <table class="table" id="listaProductosAlmacen">
                    <thead>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class='text-right pr-2'>Cantidad</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btnPrint"><i class="fas fa-print fa-fw pr-2"></i>
                    Imprimir
                </button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                        class="fas fa-ban fa-fw pr-2"></i>Cerrar</button>
            </div>
        </div>
    </div>
</div>
