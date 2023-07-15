<?php
include "Vistas/Templates/header.php";
?>
<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Historial de ventas
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table border mb-0" id="tblHistorialVentas">
                                <thead class="table-light fw-semibold">
                                    <tr class="align-middle">

                                        <th>Id</th>
                                        <th>Total</th>
                                        <th>Cliente</th>
                                        <th>Estado</th>
                                        <th>Fecha de la Venta</th>
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