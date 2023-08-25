<!-- Modal para ver Informes de Recepción -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 id='titleMdVerProdAlm' class="modal-title">Despacho de Productos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <table id="Head">
                </table>

                <input type="hidden" id="informe_id">

                <table class="table" id="listaProductosInforme">
                    <thead>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class='text-right pr-2'>Cantidad Ordenada</th>
                        <th class='text-right pr-2'>Cantidad Despachada</th>
                        <th class='text-right pr-2'>Cantidad Entregada</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                        class="fas fa-ban fa-fw pr-2"></i>Cerrar</button>
            </div>
        </div>
    </div>
</div>
