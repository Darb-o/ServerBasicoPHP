<?php
    use Lib\Route;
    use App\Controllers\HomeController;
    Route::get('/', [HomeController::class, 'index']);

    Route::get('/contact', function (){
        return 'Hola desde la pagina de contacto';
    });

    Route::get('/about', function (){
        return 'Hola desde la pagina de about';
    });

    Route::get('/courses/:id', function ($id){
        return 'Hola desde la pagina de cursos: '.$id;
    });

    Route::dispatch();