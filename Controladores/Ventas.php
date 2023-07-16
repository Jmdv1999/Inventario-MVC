<?php
class Ventas extends Controlador
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }
    public function index()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        $id_usuario = $_SESSION['id_usuario'];
        $verificar = $this->modelo->VerificarPermiso($id_usuario, 'nueva_venta');
        if (!empty($verificar)) {
            $data['productos'] = $this->modelo->listarProductos();
            $data['clientes'] = $this->modelo->listarClientes();
            $this->vista->getView($this, "index", $data);
        } else {
            header('location: ' . base_url . 'Errores/permisos');
        }
    }
    public function BuscarCodigo($codigo)
    {
        $data = $this->modelo->getProducto($codigo);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    public function Agregar()
    {
        $id = $_POST['id'];
        $datos = $this->modelo->getProductos($id);
        $id_producto = $datos['id'];
        $id_usuario = $_SESSION['id_usuario'];
        $precio = $datos['precio_venta'];
        $cantidad = $_POST['cantidad'];
        $comprobar = $this->modelo->consultarDetalle($id_producto, $id_usuario);
        if (empty($comprobar)) {
            if ($datos['cantidad'] >= $cantidad) {
                $subtotal = $precio * $cantidad;
                $data = $this->modelo->registrarDetalle($id_producto, $id_usuario, $precio, $cantidad, $subtotal);
                if ($data == "ok") {
                    $msg = array('msg' => 'Producto Agregado con exito', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al Agregar', 'icono' => 'error');
                }
            } else {
                $msg = array('msg' => 'No hay suficientes productos en el inventario', 'icono' => 'warning');
            }
        } else {
            $total_cantidad = $comprobar['cantidad'] + $cantidad;
            $subtotal = $total_cantidad * $precio;
            if ($datos['cantidad'] > $total_cantidad) {
                $data = $this->modelo->actualizarDetalle($precio, $total_cantidad, $subtotal, $id_producto, $id_usuario);
                if ($data == "modificado") {
                $msg = array('msg' => 'Producto Agregado con exito', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al Agregar', 'icono' => 'error');
                }
            }
            else {
                $msg = array('msg' => 'No hay suficientes productos en el inventario', 'icono' => 'warning');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Listar()
    {
        $id_usuario = $_SESSION['id_usuario'];
        $data['detalle'] = $this->modelo->getDetalle($id_usuario);
        $data['total_pagar'] = $this->modelo->calcularVenta($id_usuario);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Borrar($id)
    {
        $data = $this->modelo->borrarVenta($id);
        if ($data == "ok") {
            $msg = array('msg' => 'Campo eliminado', 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function RegistrarVenta($id_usuario)
    {
        $id_usuario = $_SESSION['id_usuario'];
        $verificar = $this->modelo->verificarCaja($id_usuario);
        if (empty($verificar)) {
            $msg = array('msg' => 'La caja esta Cerrada', 'icono' => 'error');
        } else {
            $cliente = $_POST['cliente'];
            $total = $this->modelo->calcularVenta($id_usuario);
            $data = $this->modelo->registrarVenta($id_usuario, $total['total'], $cliente);
            if ($data == "ok") {
                $detalle = $this->modelo->getDetalle($id_usuario);
                $id_venta = $this->modelo->idVenta();
                foreach ($detalle as $row) {
                    $id_producto = $row['id_producto'];
                    $cantidad = $row['cantidad'];
                    $descuento = $row['descuento'];
                    $precio = $row['precio'];
                    $subtotal = $cantidad * $precio;
                    $this->modelo->registrarDetalleVenta($id_venta['id'], $id_producto, $cantidad, $descuento, $precio, $subtotal);
                    $stock_actual = $this->modelo->getProductos($id_producto);
                    $stock = $stock_actual['cantidad'] - $cantidad;
                    $this->modelo->actualizarStock($id_producto, $stock);
                }
                $vaciar = $this->modelo->vaciarDetalle($id_usuario);
                if ($vaciar == "ok") {
                    $msg = array('msg' => 'ok', 'id_compra' => $id_venta['id']);
                }
            } else {
                $msg = "Error al realizar la compra";
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function GenerarPDF($id_venta)
    {
        $empresa = $this->modelo->getEmpresa();
        $productos = $this->modelo->getProVenta($id_venta);
        require('Librerias/fpdf/fpdf.php');
        $pdf = new FPDF();
        $pdf->AddPage();
        //Membrete

        $pdf->setTitle('Reporte de compra');
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(120, 10, utf8_decode($empresa['nombre']), 0, 1, 'C');
        $pdf->Cell(120, 10, utf8_decode($empresa['mensaje']), 0, 1, 'C');
        $pdf->Image(base_url . 'Assets/img/illustration-signup.jpg', 150, 10, 45, 45);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 5, utf8_decode($empresa['correo']), 0, 1, 'C');
        $pdf->Cell(120, 5, utf8_decode($empresa['direccion']), 0, 1, 'C');
        $pdf->Cell(120, 5, utf8_decode('RIF: ' . $empresa['rif']), 0, 1, 'C');
        $pdf->Cell(120, 5, utf8_decode($empresa['telefono']), 0, 1, 'C');
        $pdf->Cell(120, 5, utf8_decode('Folio: ' . $id_venta), 0, 1, 'C');
        $pdf->Ln(20);

        //Encabezado
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 10, utf8_decode('Cliente: ' . $productos[0]['nombre_cliente']), 0, 1, 'L', 0);
        $pdf->Cell(190, 10, utf8_decode('C.I: ' . $productos[0]['cedula']), 0, 1, 'L', 0);
        $pdf->Cell(35, 10, utf8_decode('Cantidad'), 1, 0, 'C', 0);
        $pdf->Cell(50, 10, utf8_decode('Descripcion'), 1, 0, 'C', 0);
        $pdf->Cell(35, 10, utf8_decode('Precio'), 1, 0, 'C', 0);
        $pdf->Cell(35, 10, utf8_decode('Descuento'), 1, 0, 'C', 0);
        $pdf->Cell(35, 10, utf8_decode('Subtotal'), 1, 0, 'C', 0);
        $pdf->Ln(10);
        $total = 0;
        $descuento = 0;
        foreach ($productos as $row) {
            $pdf->Cell(35, 10, utf8_encode($row['cantidad']), 0, 0, 'C', 0);
            $pdf->Cell(50, 10, utf8_encode($row['descripcion']), 0, 0, 'C', 0);
            $pdf->Cell(35, 10, utf8_encode($row['precio']), 0, 0, 'C', 0);
            $pdf->Cell(35, 10, utf8_encode($row['descuento']), 0, 0, 'C', 0);
            $pdf->Cell(35, 10, utf8_encode($row['subtotal']), 0, 0, 'C', 0);
            $pdf->Ln(10);
            $total = $total + $row['subtotal'];
            $descuento = $descuento + $row['descuento'];
        }
        $pdf->Cell(190, 10, utf8_encode('Total productos: ' . $total), 0, 1, 'R', 0);
        $pdf->Cell(190, 10, utf8_encode('Descuento: ' . $descuento), 0, 1, 'R', 0);
        $pdf->Cell(190, 10, utf8_encode('Total pagado: ' . ($total - $descuento)), 0, 1, 'R', 0);
        $pdf->Output();
    }
    public function Historial()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        $id_usuario = $_SESSION['id_usuario'];
        $verificar = $this->modelo->VerificarPermiso($id_usuario, 'historial_ventas');
        if (!empty($verificar)) {
            $this->vista->getView($this, "historial");
        } else {
            header('location: ' . base_url . 'Errores/permisos');
        }
    }
    public function ListarHistorial()
    {
        $data = $this->modelo->getHistorial();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge text-bg-success">Completada</span>';
                $data[$i]['acciones'] =
                    '<div>
                        <button class="btn btn-warning text-white btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Anular compra" data-container="body" target="_blank" data-animation="true" onclick="btnAnularVenta(' . $data[$i]['id'] . ')"><i class="fas fa-times"></i></button>
                        <a href="' . base_url . "Ventas/GenerarPDF/" . $data[$i]['id'] . '"class="btn btn-danger text-white btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Imprimir" data-container="body" target="_blank" data-animation="true" ><i class="fa-solid fa-file-pdf"></i></a>
                    </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge text-bg-danger text-white">Cancelada</span>';
                $data[$i]['acciones'] = '<div>
                <a href="' . base_url . "Ventas/GenerarPDF/" . $data[$i]['id'] . '"class="btn btn-danger text-white btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Imprimir" data-container="body" target="_blank" data-animation="true" ><i class="fa-solid fa-file-pdf"></i></a>
                </div>';
            };
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function CalcularDescuento($datos)
    {
        $array = explode(",", $datos);
        $id = $array[0];
        $descuento = $array[1];
        if (empty($id) || empty($descuento)) {
            $msg = array('msg' => 'Error', 'icono' => 'warning');
        } else {
            $descuentoactual = $this->modelo->verificarDescuento($id);
            $descuentototal = $descuentoactual['descuento'] + $descuento;
            $subtotal = ($descuentoactual['cantidad'] * $descuentoactual['precio']) - $descuentototal;
            $data = $this->modelo->actualizarDescuento($descuentototal, $subtotal, $id);
            if ($data == "ok") {
                $msg = array('msg' => 'Descuento aplicado', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'No se aplico el descuento', 'icono' => 'error');
            }
            echo json_encode($msg);
            die();
        }
    }
    public function AnularVenta($id_compra)
    {
        $datos = $this->modelo->getProVenta($id_compra);
        $anular = $this->modelo->getAnular($id_compra);
        foreach ($datos as $row) {
            $stock_actual = $this->modelo->getProductos($row['id_producto']);
            $stock = $stock_actual['cantidad'] + $row['cantidad'];
            $data = $this->modelo->actualizarStock($stock, $row['id_producto']);
        }
        if ($anular == 'ok') {
            $msg = array('msg' => 'Venta anulada', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'no se pudo anular', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Salir()
    {
        session_destroy();
        header("location: " . base_url);
    }
}
