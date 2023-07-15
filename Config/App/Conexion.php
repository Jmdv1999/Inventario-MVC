<?php
    class Conexion{
        public function __construct()
        {
            $pdo = "mysql:host=".host.";dbname=".db.";.charset.";
            try {
                $this->conect = new PDO($pdo, usuario, pass);
                $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error de Conexion: ".$e->getMessage();
            }
        }
        public function conect(){
            return $this->conect;
        }
    }
?>