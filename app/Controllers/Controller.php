<?php

namespace App\Controllers;
class Controller{
    //el primer argumento es la vista a servir, y el segundo la data opcional que provenga
    public function view($route, $data = []){
        //desestructurar la data, creando variables con las llaves del arreglo
        extract($data);
        $route = str_replace('.','/', $route);
        /*verificar si existe el path, hay que tomar en cuenta
        que se esta llamando desde el public*/
        if(file_exists("../resources/views/{$route}.php")){
            //trae el contenido pero lo almacena en vez de mostrarlo
            ob_start();
            include "../resources/views/{$route}.php";
            $content = ob_get_clean();
            return $content;
        }else{
            return "El archivo no existe";
        }
    }
}