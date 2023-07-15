<?php
include "Vistas/Templates/header.php";
?>
<!--Modal-->

<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card mb-4">
                    <div class="card-header">
                        Asignar permisos
                    </div>
                    <div class="card-body">
                        <form id="frmPermisos" onsubmit="registrarPermisos(event)">
                            <input type="hidden" name="id_usuario" value="<?php echo $data['id_usuario'];?>">
                            <div class="row p-3">
                                <?php foreach ($data['datos'] as $row) { ?>
                                    <div class="form-check form-switch col-sm-6 col-md-4 mt-4">
                                        <input class="form-check-input" type="checkbox" role="switch" name="permisos[]" value="<?php echo $row['id'];?>" <?php echo isset($data['asignados'][$row['id']]) ? 'checked': '' ;?>>
                                        <label class="form-check-label" for="flexconfiguracion"><?php echo $row['permiso'];?></label>
                                    </div>
                                <?php } ?>
                            </div>
                            <button type="submit" class="btn btn-primary nt-3">Guardar</button>
                            <a href="<?php echo base_url;?>Usuarios" class="btn btn-danger nt-3 text-white">Cancelar</a>
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