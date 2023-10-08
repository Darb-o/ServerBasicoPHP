<?php
    //basicamente toma cada namespace y lo toma para no requerir cada archivo que se llame
    spl_autoload_register( function($clase){
        $ruta = '../'.str_replace("\\","/", $clase).".php";
        if(file_exists($ruta)){
            require_once $ruta;
        }else{
            die("No se pudo cargar la clase $clase");
        }
    });