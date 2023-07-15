<?php
include "Vistas/Templates/header.php";
?>
<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Datos de la empresa
                    </div>

                    <div class="card-body">
                        <form id="frmEmpresa">
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label">Nombre</label>
                                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data['id'] ?>">
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $data['nombre'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label">RIF</label>
                                        <input type="text" class="form-control" id="rif" name="rif" value="<?php echo $data['rif'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <div>
                                        <label class="form-label">Telefono</label>
                                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $data['telefono'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <div>
                                        <label class="form-label">Correo</label>
                                        <input type="text" class="form-control" id="correo" name="correo" value="<?php echo $data['correo'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <div>
                                        <label class="form-label">Direccion</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $data['direccion'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <div>
                                        <label class="form-label">Slogan</label>
                                        <input type="text" class="form-control" id="mensaje" name="mensaje" value="<?php echo $data['mensaje'] ?>">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary mt-3" onclick="ModificarEmpresa()">Modificar</button>
                        </form>
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