<?php

namespace App\Controllers;
//Se hereda el metodo de la vista puesto que se tienen a reutilizar
class HomeController extends Controller{

    public function index(){
        /*si se especifica home, es la ubicacion, pero si este se encuentra
        dentro de una carpeta hay que especificar*/
        return $this->view('home', [
            'title' => 'Home',
            'description' => 'Esta es la página principal'
        ]);
    }

}