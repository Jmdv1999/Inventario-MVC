<?php
    class Controlador{
        public function __construct()
        {
            $this->CargarModelo();
            $this->vista = new Vistas();
        }
        public function CargarModelo(){
            $modelo = get_class($this)."Model";
            $ruta = "Modelos/".$modelo.".php";
            if(file_exists($ruta)){
                require_once $ruta;
                $this->modelo = new $modelo();
            }
        }
    }
?>