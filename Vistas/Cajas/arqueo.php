<?php
include "Vistas/Templates/header.php";
?>
<!--Modal-->
<div class="modal fade" id="abrir-caja" tabindex="-1" role="dialog" aria-labelledby="abrir-caja" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header">
                        <h6 class="modal-title font-weight-normal" id="titulo">Arqueo caja</h6>
                    </div>
                    <form role="form text-left" method="POST" id="frmAbrirCaja" onsubmit="AbrirArqueo(event)">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <label class="form-label">Monto inicial</label>
                                        <input type="text" class="form-control" id="montoinicial" name="montoinicial" placeholder="Monto inicial">
                                        <input type="hidden" id="id" name="id">
                                    </div>
                                    <div id="elementos_cierre">
                                        <div>
                                            <label class="form-label">Monto final</label>
                                            <input type="text" class="form-control" id="montofinal" name="montofinal" placeholder="Monto final" disabled>
                                        </div>
                                        <div>
                                            <label class="form-label">Total ventas</label>
                                            <input type="text" class="form-control" id="totalventas" name="totalventas" placeholder="Total ventas" disabled>
                                        </div>
                                        <div>
                                            <label class="form-label">Motal total</label>
                                            <input type="text" class="form-control" id="montototal" name="montototal" placeholder="Monto Total" disabled>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Arqueo de Cajas
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#abrir-caja" onclick="ArqueoCaja();"> <i class="fas fa-box"></i></button>
                        <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#abrir-caja" onclick="CerrarCaja();"> <i class="fas fa-minus"></i></button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table border mb-0" id="tblArqueoCajas">
                                <thead class="table-light fw-semibold">
                                    <tr class="align-middle">
                                        <th>Id</th>
                                        <th>usuario</th>
                                        <th>Monto inicial</th>
                                        <th>Monto final</th>
                                        <th>Fecha apertura</th>
                                        <th>Fecha cierre</th>
                                        <th>Total Ventas</th>
                                        <th>Monto total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="align-middle">
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->
    </div>
</div>
<?php
include "Vistas/Templates/footer.php";
?>