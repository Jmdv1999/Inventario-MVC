<?php
include "Vistas/Templates/header.php";
?>
<div class="modal fade" id="modal-cliente" tabindex="-1" role="dialog" aria-labelledby="modal-cliente" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header">
                        <h6 class="modal-title font-weight-normal" id="titulo">Agregar Cliente</h6>
                    </div>
                    <div class="card-body">
                        <form role="form text-left" method="POST" id="frmClienteReg">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <label class="form-label">Cedula</label>
                                        <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cedula">
                                        <input type="hidden" id="id" name="id">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div>
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div>
                                        <label class="form-label">Telefono</label>
                                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div>
                                        <label class="form-label">Direccion</label>
                                        <textarea cols="30" rows="3" class="form-control" id="direccion" name="direccion" placeholder="Direccion" style="resize: none;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="frmClientes(event)">Guardar</button>
                    </div>
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
                        Clientes
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modal-cliente" onclick="ArreglarCliente();"> <i class="fas fa-user-plus"></i></button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table border mb-0" id="tblClientes">
                                <thead class="table-light fw-semibold">
                                    <tr class="align-middle">
                                        <th>Id</th>
                                        <th>Cedula</th>
                                        <th>Nombre</th>
                                        <th>Telefono</th>
                                        <th>Direccion</th>
                                        <th>Estado</th>
                                        <th></th>
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