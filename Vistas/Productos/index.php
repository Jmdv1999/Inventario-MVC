<?php
include "Vistas/Templates/header.php";
?>
<!--Modal-->
<div class="modal fade" id="modal-producto" tabindex="-1" role="dialog" aria-labelledby="modal-producto" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header">
                        <h6 class="modal-title font-weight-normal" id="titulo">Agregar Producto</h6>
                    </div>
                    <div class="card-body">
                        <form role="form text-left" method="POST" id="frmProductosReg">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div>
                                        <label for="codigo" class="form-label">Codigo de producto</label>
                                        <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Codigo de producto">
                                        <input type="hidden" id="id" name="id">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label for="descripcion" class="form-label">Descripcion</label>
                                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripción">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label for="compra" class="form-label">Precio de Compra</label>
                                        <input type="text" class="form-control" id="compra" name="compra" placeholder="Precio de Comprra">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label for="venta" class="form-label">Precio Venta</label>
                                        <input type="text" class="form-control" id="venta" name="venta" placeholder="Precio de Venta">
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2 mt-2">
                                    <div>
                                        <label for="categoria" class="ms-0">Categoria</label>
                                        <select name="categoria" id="categoria" class="form-control">
                                            <?php foreach ($data['categorias'] as $row) { ?>
                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['nombre'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Imagen: </label>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <label for="foto" class="btn btn-primary" id="icon-image"><i class="fas fa-image"></i></label>
                                                        <span id="icon-cerrar"></span>
                                                    </div>
                                                    <div class="col-sm-10 text-end">
                                                        <input type="file" class="d-none" id="foto" name="foto" onchange="preview(event)">
                                                        <input type="hidden" name="fotoactual" id="fotoactual">
                                                        <img id="previewimg" height="150px" width="150px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="frmProductos(event)">Guardar</button>
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
                        Productos
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modal-producto" onclick="ArreglarProductos();"> <i class="fas fa-user-plus"></i></button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table border mb-0" id="tblProductos">
                                <thead class="table-light fw-semibold">
                                    <tr>
                                        <th>ID</th>
                                        <th>Imagen</th>
                                        <th>Codigo</th>
                                        <th>Descripcion</th>
                                        <th>Precio Compra</th>
                                        <th>Precio Venta</th>
                                        <th>Cantidad</th>
                                        <th>Categoria</th>
                                        <th>Estado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
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