<?php
class Compras extends Controlador
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
        $verificar = $this->modelo->VerificarPermiso($id_usuario, 'nueva_compra');
        if (!empty($verificar)) {
            $data['productos'] = $this->modelo->listarProductos();
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
        $precio = $datos['precio_compra'];
        $cantidad = $_POST['cantidad'];
        $comprobar = $this->modelo->consultarDetalle($id_producto, $id_usuario);
        if (empty($comprobar)) {
            $subtotal = $precio * $cantidad;
            $data = $this->modelo->registrarDetalle($id_producto, $id_usuario, $precio, $cantidad, $subtotal);
            if ($data == "ok") {
                $msg = 'ok';
            }
        } else {
            $total_cantidad = $comprobar['cantidad'] + $cantidad;
            $subtotal = $total_cantidad * $precio;
            $data = $this->modelo->actualizarDetalle($precio, $total_cantidad, $subtotal, $id_producto, $id_usuario);
            if ($data == "modificado") {
                $msg = 'modificado';
            } else {
                $msg = array('msg' => 'Error al ingresar', 'icono' => 'error');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Listar()
    {
        $id_usuario = $_SESSION['id_usuario'];
        $data['detalle'] = $this->modelo->getDetalle($id_usuario);
        $data['total_pagar'] = $this->modelo->calcularCompra($id_usuario);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Borrar($id)
    {
        $data = $this->modelo->borrarCompra($id);
        if ($data == "ok") {
            $msg = "ok";
        } else {
            $msg = "error";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function RegistrarCompra()
    {
        $id_usuario = $_SESSION['id_usuario'];
        $total = $this->modelo->calcularCompra($id_usuario);
        $data = $this->modelo->registrarCompra($total['total']);
        if ($data == "ok") {
            $detalle = $this->modelo->getDetalle($id_usuario);
            $id_compra = $this->modelo->idCompra();
            foreach ($detalle as $row) {
                $id_producto = $row['id_producto'];
                $cantidad = $row['cantidad'];
                $precio = $row['precio'];
                $subtotal = $cantidad * $precio;
                $this->modelo->registrarDetalleCompra($id_compra['id'], $id_producto, $cantidad, $precio, $subtotal);
                $stock_actual = $this->modelo->getProductos($id_producto);
                $stock = $stock_actual['cantidad'] + $cantidad;
                $this->modelo->actualizarStock($stock, $id_producto);
            }
            $vaciar = $this->modelo->vaciarDetalle($id_usuario);
            if ($vaciar == "ok") {
                $msg = array('msg' => 'ok', 'id_compra' => $id_compra['id']);
            }
        } else {
            $msg = "Error al realizar la compra";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function GenerarPDF($id_compra)
    {
        $empresa = $this->modelo->getEmpresa();
        $productos = $this->modelo->getProCompra($id_compra);
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
        $pdf->Cell(120, 5, utf8_decode('Folio: ' . $id_compra), 0, 1, 'C');
        $pdf->Ln(20);
        //Encabezado
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(35, 10, utf8_decode('Cantidad'), 1, 0, 'C', 0);
        $pdf->Cell(85, 10, utf8_decode('Descripcion'), 1, 0, 'C', 0);
        $pdf->Cell(35, 10, utf8_decode('Precio'), 1, 0, 'C', 0);
        $pdf->Cell(35, 10, utf8_decode('Subtotal'), 1, 0, 'C', 0);
        $pdf->Ln(10);
        $total = 0;
        foreach ($productos as $row) {
            $pdf->Cell(35, 10, utf8_encode($row['cantidad']), 0, 0, 'C', 0);
            $pdf->Cell(85, 10, utf8_encode($row['descripcion']), 0, 0, 'C', 0);
            $pdf->Cell(35, 10, utf8_encode($row['precio']), 0, 0, 'C', 0);
            $pdf->Cell(35, 10, utf8_encode($row['subtotal']), 0, 0, 'C', 0);
            $pdf->Ln(10);
            $total = $total + $row['subtotal'];
        }
        $pdf->Cell(190, 10, utf8_encode('Total pagado: ' . $total), 0, 0, 'R', 0);
        $pdf->Output();
    }
    public function Historial()
    {
        $id_usuario = $_SESSION['id_usuario'];
        $verificar = $this->modelo->VerificarPermiso($id_usuario, 'historial_compras');
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
                    <button class="btn btn-warning text-white btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Anular compra" data-container="body" target="_blank" data-animation="true" onclick="btnAnularCompra(' . $data[$i]['id'] . ')"><i class="fas fa-times"></i></button>
                    <a href="' . base_url . "Compras/GenerarPDF/" . $data[$i]['id'] . '"class="btn btn-danger text-white btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Imprimir" data-container="body" target="_blank" data-animation="true"><i class="fa-solid fa-file-pdf"></i></a>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge text-bg-danger text-white">Cancelada</span>';
                $data[$i]['acciones'] = '<div>
                    <a href="' . base_url . "Compras/GenerarPDF/" . $data[$i]['id'] . '"class="btn btn-danger text-white btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Imprimir" data-container="body" target="_blank" data-animation="true"><i class="fa-solid fa-file-pdf"></i></a>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function AnularCompra($id_compra)
    {
        $datos = $this->modelo->getProCompra($id_compra);
        $anular = $this->modelo->getAnular($id_compra);
        foreach ($datos as $row) {
            $stock_actual = $this->modelo->getProductos($row['id_producto']);
            $stock = $stock_actual['cantidad'] - $row['cantidad'];
            $data = $this->modelo->actualizarStock($stock, $row['id_producto']);
        }
        if ($anular == 'ok') {
            $msg = array('msg' => 'compra anulada', 'icono' => 'success');
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
