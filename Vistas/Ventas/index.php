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
                        <form id="frmVenta">
                            <input type="hidden" id="id" name="id">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="input-group input-group-outline">
                                        <select name="codigo" id="codigo" class="codigo form-control" onchange="buscarCodigoVenta()">
                                            <option value="" style="color:#333b !important;">Seleccione producto</option>
                                            <?php foreach ($data['productos'] as $row) { ?>
                                                <option style="color:#000 !important;" value="<?php echo $row['codigo'] ?>"><?php echo $row['descripcion'] ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div>
                                        <input type="text" class="form-control" id="cantidad" name="cantidad" disabled onchange="calcularPrecio()" placeholder="cantidad">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div>
                                        <input type="text" class="form-control" id="precio" name="precio" disabled placeholder="precio">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div>
                                        <input type="text" class="form-control" id="subtotal" name="subtotal" disabled placeholder="Sub Total
                ">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-primary" onclick="agregarVenta(event)"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Descripcion</th>
                                        <th>Cantidad</th>
                                        <th>Aplicar</th>
                                        <th>Descueto</th>
                                        <th>Precio</th>
                                        <th>Sub Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="listaVenta">

                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4 ms-xl-auto">
                                <form id="frmVendido">
                                    <div class="form-group">
                                        <div class="input-group input-group-outline">
                                            <select name="cliente" id="cliente" class="codigo form-control">
                                                <option value="" style="color:#333b !important;">Seleccione Cliente</option>
                                                <?php foreach ($data['clientes'] as $row) { ?>
                                                    <option style="color:#000 !important;" value="<?php echo $row['id'] ?>"><?php echo $row['nombre'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="input-group input-group-outline mt-2">
                                            <input type="text" class="form-control" id="total" name="total" disabled placeholder="Total">
                                            <button class="btn btn-primary w-100 mt-2" type="button" onclick="vender(event)">Generar</button>
                                        </div>
                                    </div>
                                </form>
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