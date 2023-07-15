<?php
include "Vistas/Templates/header.php";
?>
<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Realizar Venta
                    </div>
                    <div class="card-body">
                        <form id="frmCompra">
                            <input type="hidden" id="id" name="id">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="input-group input-group-outline">
                                        <select name="codigo" id="codigo" class="codigo form-control" onchange="buscarCodigo()">
                                            <option value="" style="color:#333b !important;">Seleccione producto</option>
                                            <?php foreach ($data['productos'] as $row) { ?>
                                                <option style="color:#000 !important;" value="<?php echo $row['codigo'] ?>"><?php echo $row['descripcion'] ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group input-group-outline">
                                        <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder ="Cantidad" disabled onchange="calcularPrecio()">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group input-group-outline">
                                        <input type="text" class="form-control" id="precio" name="precio"placeholder ="Precio"  disabled>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group input-group-outline">
                                        <input type="text" class="form-control" id="subtotal" placeholder ="Sub Total" name="subtotal" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-primary" onclick="agregar(event)"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descripcion</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cantidad</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Precio</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sub Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="listaCompra">

                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="input-group input-group-outline">
                                        <input type="text" class="form-control" id="total" name="total" disabled>
                                        <button class="btn btn-primary w-100 mt-2" type="button" onclick="comprar(event)">Generar</button>
                                    </div>
                                </div>
                            </div>
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