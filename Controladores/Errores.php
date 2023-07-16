<?php
    class Errores extends Controlador{
        public function __construct(){
            parent::__construct();
        }
        public function index(){
            $this->vista->getView($this, "index");
        }
        public function permisos(){
            $this->vista->getView($this, "permisos");
        }
    }
