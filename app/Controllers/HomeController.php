<?php

namespace App\Controllers;

use App\Models\Contact;
//Se hereda el metodo de la vista puesto que se tienen a reutilizar
class HomeController extends Controller{

    public function index(){
        $contactModel = new Contact();
        return $contactModel->create([
            'name' => 'Papaya',
            'email' => 'De celaya',
            'phone' => '9517538246'
        ]);
        /*si se especifica home, es la ubicacion, pero si este se encuentra
        dentro de una carpeta hay que especificar*/
        return $this->view('home', [
            'title' => 'mamabuevo',
            'description' => 'Esta es la página principal'
        ]);
    }

}