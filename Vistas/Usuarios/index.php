<?php
include "Vistas/Templates/header.php";
?>
<!--Modal-->
<div class="modal fade" id="modal-form" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header">
                        <h6 class="modal-title font-weight-normal" id="titulo">Agregar Usuario</h6>
                    </div>
                    <div class="card-body">
                        <form role="form text-left" method="POST" id="frmUsuariosReg">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="usuario" class="form-label">Usuario</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario">
                                    <input type="hidden" id="id" name="id">
                                </div>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                                </div>
                                <div class="col-sm-12" id="claves">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="clave" class="form-label">Contraseña</label>
                                                <input type="text" class="form-control" id="clave" name="clave" placeholder="Contraseña">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="clave" class="form-label">Confirmar Contraseña</label>
                                                <input type="text" class="form-control" id="confirm" name="confirm" placeholder="Confirmar Contraseña">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <select name="caja" id="caja" class="form-control">
                                            <?php foreach ($data['cajas'] as $row) { ?>
                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['caja'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="frmUsuarios(event)">Guardar</button>
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
                        Usuarios
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal-form" data-bs-target="#modal-form" onclick="Arreglar();"> <i class="fas fa-user-plus"></i></button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table border mb-0" id="tblUsuarios">
                                <thead class="table-light fw-semibold">
                                    <tr class="align-middle">
                                        <th class="">ID</th>
                                        <th>Usuario</th>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                        <th>Caja</th>
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