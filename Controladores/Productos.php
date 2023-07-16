<?php
header('Access-Control-Allow-Origin: http://localhost:8080');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, Content-Type, Accept, Access-Control-Request-Method");
class Productos extends Controlador
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
        $verificar = $this->modelo->VerificarPermiso($id_usuario, 'productos');
        if (!empty($verificar)) {
            $data['categorias'] = $this->modelo->getCategorias();
            $this->vista->getView($this, "index", $data);
        } else {
            header('location: ' . base_url . 'Errores/permisos');
        }
    }
    public function listar()
    {
        $data = $this->modelo->getProductos();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge text-bg-success">Activo</span>';
                $data[$i]['imagen'] = '<img class="img-thumbnail" style="height:64px; width:64px ;" src="' . base_url . "Assets/img/" . $data[$i]['foto'] . '">';
                $data[$i]['acciones'] = '<div>
                                            <button type="button" class="btn btn-secondary btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-container="body" data-animation="true" onclick="btnEditarProducto(' . $data[$i]['id'] . ');"><i class="fa-solid fa-pen-to-square"></i></button> 
                                            <button ttype="button" class="btn btn-danger btn-sm btn-tooltip text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Desactivar" data-container="body" data-animation="true" onclick="btnEliminarProducto(' . $data[$i]['id'] . ');"><i class="fa-solid fa-trash"></i></button>
                                        </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge text-bg-warning text-white">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                                                <button type="button" class="btn btn-success btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Activar" data-container="body" data-animation="true" onclick="btnActivarProducto(' . $data[$i]['id'] . ');"><i class="fa-solid fa-play"></i></button>
                                            </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Registrar()
    {
        $codigo = $_POST['codigo'];
        $descripcion = $_POST['descripcion'];
        $precio_compra = $_POST['compra'];
        $precio_venta = $_POST['venta'];
        $categoria = $_POST['categoria'];
        $id = $_POST['id'];
        $img = $_FILES['foto'];
        $nombre_img = $img['name'];
        $nombre_tmp = $img['tmp_name'];
        $fotoactual = $_POST['fotoactual'];
        $fecha_img = date("YmdHis");
        if (!empty($nombre_img)) {
            $img_nombre = $fecha_img . ".jpg";
            $destino = "Assets/img/" . $img_nombre;
        } else if (!empty($_POST['fotoactual']) && empty($nombre_img)) {
            $img_nombre = $fotoactual;
        } else {
            $img_nombre = "default.png";
        }
        if (empty($descripcion)) {
            $msg = array('msg' => 'Descripcion es obligatorio', 'icono' => 'warning');
        } else {
            if ($id == "") {
                $data = $this->modelo->RegistrarProducto($codigo, $descripcion, $precio_compra, $precio_venta, $categoria, $img_nombre);
                if ($data == "ok") {
                    $msg = array('msg' => 'Producto registrado', 'icono' => 'success');
                    if (!empty($nombre_img)) {
                        move_uploaded_file($nombre_tmp, $destino);
                    }
                } else if ($data == "existe") {

                    $msg = array('msg' => 'El producto ya existe', 'icono' => 'warning');
                } else {

                    $msg = array('msg' => 'Error al registrat', 'icono' => 'error');
                }
            } else {
                $imagen_delete = $this->modelo->EditarProducto($id);
                if ($imagen_delete['foto'] != 'default.png') {
                    if (file_exists("Assets/img/" . $imagen_delete['foto'])) {
                        unlink("Assets/img/" . $imagen_delete['foto']);
                    }
                }
                $data = $this->modelo->ModificarProducto($codigo, $descripcion, $precio_compra, $precio_venta, $categoria, $img_nombre, $id);
                if ($data == "modificado") {
                    if (!empty($nombre_img)) {
                        move_uploaded_file($nombre_tmp, $destino);
                    }

                    $msg = array('msg' => 'Producto modificado', 'icono' => 'success');
                } else {

                    $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Editar(int $id)
    {
        $data = $this->modelo->EditarProducto($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Eliminar(int $id)
    {
        $data = $this->modelo->AccionProducto(0, $id);
        if ($data == 1) {

            $msg = array('msg' => 'Producto eliminado con exito', 'icono' => 'success');
        } else {

            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Activar(int $id)
    {
        $data = $this->modelo->AccionProducto(1, $id);
        if ($data == 1) {

            $msg = array('msg' => 'producto activado', 'icono' => 'success');
        } else {

            $msg = array('msg' => 'error al activar', 'icono' => 'error');
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
