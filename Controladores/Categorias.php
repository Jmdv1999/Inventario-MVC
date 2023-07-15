<?php
    class Categorias extends Controlador{
        public function __construct(){
            session_start();
            if(empty($_SESSION['activo'])){
                header("location: ".base_url);
            }
            parent::__construct();
        }
        public function index(){
            if (empty($_SESSION['activo'])) {
                header("location: " . base_url);
            }
            $id_usuario = $_SESSION['id_usuario'];
            $verificar = $this->modelo->VerificarPermiso($id_usuario, 'categorias');
            if (!empty($verificar)){
                $this->vista->getView($this, "index");
            }
            else {
                header('location: '.base_url.'Errores/permisos');
            }
        }
        public function listar(){
            $data = $this->modelo->getCategorias();
            for ($i=0; $i < count($data); $i++) {
                if ($data[$i]['estado'] == 1) {
                    $data[$i]['estado'] = '<span class="badge text-bg-success">Activo</span>';
                    $data[$i]['acciones'] = 
                                            '<div>
                                                <button type="button" class="btn btn-secondary btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-container="body" data-animation="true" onclick="btnEditarCategorias('.$data[$i]['id'].');"><i class="fa-solid fa-pen-to-square"></i></button> 
                                                <button ttype="button" class="btn btn-danger text-white btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Desactivar" data-container="body" data-animation="true" onclick="btnEliminarCategorias('.$data[$i]['id'].');"><i class="fa-solid fa-trash"></i></button>
                                            </div>';
                }
                else{
                    $data[$i]['estado'] = '<span class="badge text-bg-danger text-white">Inactivo</span>';
                    $data[$i]['acciones'] = '<div>
                                                <button type="button" class="btn btn-success btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Activar" data-container="body" data-animation="true" onclick="btnActivarCategorias('.$data[$i]['id'].');"><i class="fa-solid fa-play"></i></button>
                                            </div>';
                }
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
        public function Registrar(){
            $nombre = $_POST['nombre'];
            $id = $_POST['id'];
            if (empty($nombre)) {
                $msg = array('msg' => 'Nombre es obligatorio', 'icono' => 'warning');
            }
            else{
                if ($id == "") {
                    $data = $this->modelo->RegistrarCategoria($nombre);
                    if ($data == "ok") {
                        $msg = array('msg' => 'Categoria registrada con exito', 'icono' => 'success');
                    }
                    else if($data == "existe"){
                        $msg = array('msg' => 'La categoria ya existe', 'icono' => 'warning');
                    }
                    else{
                        $msg = array('msg' => 'Error al registrar', 'icono' => 'warning');
                    }
                }
                else{
                    $data = $this->modelo->ModificarCategoria( $nombre, $id);
                    if ($data == "modificado") {
                        $msg = array('msg' => 'Categoria modificada con exito', 'icono' => 'success');
                    }
                    else{
                        $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                    }
                }
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
        public function Editar(int $id){
            $data = $this->modelo->EditarCategoria($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
        public function Eliminar(int $id){
            $data = $this->modelo->AccionCategoria(0, $id);
            if($data == 1){
                
                $msg = array('msg' => 'Categoria desactivada con exito', 'icono' => 'succes');
            }
            else{
                $msg = array('msg' => 'error al desactivar', 'icono' => 'error');
            }
            echo json_encode ($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
        public function Activar(int $id){
            $data = $this->modelo->AccionCategoria(1, $id);
            if($data == 1){
                $msg = array('msg' => 'Categoria activada con exito', 'icono' => 'success');
            }
            else{
                $msg = array('msg' => 'Error al activar', 'icono' => 'error');
            }
            echo json_encode ($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
        public function Salir(){
            session_destroy();
            header("location: ".base_url);
        }
    }
?>