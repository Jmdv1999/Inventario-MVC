<?php
include "Vistas/Templates/header.php";
?>
<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Administracion
                        <div class="row mt-3">
                            <div class="col-xs-3 col-sm-3 text-white">
                                <div class="card bg-primary">
                                    <div class="card-body d-flex">
                                        <h5>Usuarios</h5>
                                        <i class="fas fa-user fa-2x ms-auto"></i>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="text-white" href="<?php echo base_url; ?>Usuarios">Ver detalles</a>
                                        <span><?php echo $data['usuarios']['total'] ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 text-white">
                                <div class="card bg-success">
                                    <div class="card-body d-flex">
                                        <h5> Clientes</h5>
                                        <i class="fas fa-users fa-2x ms-auto"></i>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="text-white" href="<?php echo base_url; ?>Clientes">Ver detalles</a>
                                        <span><?php echo $data['clientes']['total'] ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 text-white">
                                <div class="card bg-danger">
                                    <div class="card-body d-flex">
                                        <h5>Productos</h5>
                                        <i class="fab fa-product-hunt fa-2x ms-auto"></i>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="text-white" href="<?php echo base_url; ?>Productos">Ver detalles</a>
                                        <span><?php echo $data['productos']['total'] ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 text-white">
                                <div class="card bg-warning">
                                    <div class="card-body d-flex">
                                        <h5>Ventas de hoy</h5>
                                        <i class="fas fa-cash-register fa-2x ms-auto"></i>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="text-white" href="<?php echo base_url; ?>Ventas/Historial">Ver detalles</a>
                                        <span><?php echo $data['ventas']['totalventas'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-header">
                                        Productos con stock minimo
                                    </div>
                                    <div class="card-body">
                                        <canvas id="StockMinimo" width="400" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-header">
                                        Productos mas vendidos
                                    </div>
                                    <div class="card-body">
                                        <canvas id="MasVendidos" width="400" height="400"></canvas>
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

<script src="<?php echo base_url; ?>Assets/js/chart.min.js"></script>
<script>
    MasVendidos()

    function MasVendidos() {
        const url = "http://localhost/Inventario-MVC/Configuracion/MasVendidos";
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send();
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                let nombre = [];
                let cantidad = [];
                for (let i = 0; i < res.length; i++) {
                    nombre.push(res[i]['descripcion']);
                    cantidad.push(res[i]['total']);
                }
                masVendido = document.getElementById('MasVendidos');
                var ChartVendidos = new Chart(masVendido, {
                    type: 'pie',
                    data: {
                        labels: nombre,
                        datasets: [{
                            label: 'My First Dataset',
                            data: cantidad,
                            backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)'],
                            hoverOffset: 4
                        }],
                    },
                });
            }
        }

    }
</script>
<script>
    ReporteStock()

    function ReporteStock() {
        const url = "http://localhost/Inventario-MVC/Configuracion/ReporteStock";
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send();
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                let nombre = [];
                let cantidad = [];
                for (let i = 0; i < res.length; i++) {
                    nombre.push(res[i]['descripcion']);
                    cantidad.push(res[i]['cantidad']);
                }
                stockMinimo = document.getElementById('StockMinimo');
                var ChartMinimo = new Chart(stockMinimo, {
                    type: 'pie',
                    data: {
                        labels: nombre,
                        datasets: [{
                            label: 'My First Dataset',
                            data: cantidad,
                            backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)', '#20c997', '#fd7e14'],
                            hoverOffset: 4
                        }],
                    },
                });
            }
        }
    }
</script>
<?php
include "Vistas/Templates/footer.php"; ?>