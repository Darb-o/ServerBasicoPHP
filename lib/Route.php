<?php

namespace Lib;

class Route{

    //se hacen estaticos con tal de no instanciar

    private static $routes = [];

    //como no se puede asignar una funcion, se crea una funcion que la llame
    public static function get($uri, $callback){
        $uri = trim($uri, '/');
        self::$routes['GET'][$uri] = $callback;
    }

    public static function post($uri, $callback){
        $uri = trim($uri, '/');
        self::$routes['POST'][$uri] = $callback;
    }   
    
    public static function dispatch(){
        //captura la uri de la ruta
        $uri = $_SERVER['REQUEST_URI'];
        $uri = trim($uri, '/');
        //captura el metodo GET o POST
        $method = $_SERVER['REQUEST_METHOD'];
        /* Recorre el arreglo de rutas y compara si coincide con las 
        definidas*/
        foreach (self::$routes[$method] as $route => $callback){
            /*busca si existe alternativas a las rutas
            Esta expresion regular solo toma despues letras mayusculas o minusculas
            si por ejemplo solo se admiten numeros o alfanumericos, la expresion se debe alterar
            en el reemplazo y en lo que toma si es que se necesita
            */
            if(strpos($route, ':')!== false){
                $route = preg_replace('#:[a-zA-Z]+#','([a-zA-Z]+)',$route);
            }
            //Comparacion usando expresion regular
            if(preg_match("#^$route$#",$uri, $matches)){
                /*genera un nuevo array con todas las posiciones del array que tenga subpatrones desde la posicion 1
                como la posicion 1 toma la cadena y despues de ello los subpatrones, se capturan los diferentes parametros
                esto en el caso de que hayan mas de una de paginas subcreadas*/
                $params = array_slice($matches,1);
                //Recibe informacion tanto como callback como array que llama a un controlador especifico
                if(is_callable($callback)){
                    $response = $callback(...$params);
                }
                /*aca lo que practicamente hace es recibir la clase y crear una instancia de ella, que ya se ubica en los controladores. Para luego en la
                variable response asignar, la repuesta de ejecutar la funcion que venga en la segunda posicion del array, adjuntandole los parametros como argumento
                y de esta forma el controlador tenga los argumentos.*/
                if(is_array($callback)){
                    $controller = new $callback[0];
                    $response = $controller->{$callback[1]}(...$params);
                }
                //si es objeto o arreglo, la parsea y la muestra
                if(is_array($response) || is_object($response)){
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }else{
                    echo $response;
                }
                return;
            }
        }
        echo '404 not found';
    }

}