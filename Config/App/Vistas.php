<?php
    class Vistas{
        public function getView($controlador, $Vista, $data=""){
            $controlador = get_class($controlador);
            if($controlador == "Home"){
                $Vista = "Vistas/".$Vista.".php";
            }
            else{
                $Vista = "Vistas/".$controlador."/".$Vista.".php";
            }
            require $Vista;
        }
    }
    
?>