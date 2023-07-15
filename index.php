<?php
    require_once "Config/Config.php";
    $ruta = !empty($_GET['url']) ? $_GET['url'] : "Home/index";
    $array = explode("/",$ruta);
    $controlador = $array[0];
    $metodo = "index";
    $parametro = "";
    if(!empty($array[1])){
        if(!empty($array[1] != "")){
            $metodo = $array[1];
        }
    }
    if(!empty($array[2])){
        if(!empty($array[2] != "")){
            for ($i=2; $i < count($array); $i++) { 
                $parametro .= $array[$i].",";
            }
            $parametro = trim($parametro, ",");
        }
    }
    require_once "Config/App/Autoload.php";
    $dirControladores = "Controladores/".$controlador.".php";
    if(file_exists($dirControladores)){
        require_once $dirControladores;
        $controlador = new $controlador();
        if(method_exists($controlador,$metodo)){
            $controlador->$metodo($parametro);
        }
        else{
            echo "no existe el metodo";
            //header('location: '.base_url.'Errores');
        }
    }
    else{
        echo "no existe el controlador";
        //header('location: '.base_url.'Errores');
    }
?>