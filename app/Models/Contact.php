<?php
namespace App\Models;
use mysqli;
class Contact{
    protected $db_host = DB_HOST;
    protected $db_user = DB_USER;
    protected $db_pass = DB_PASS;
    protected $db_name = DB_NAME;

    protected $connection;
    protected $query;

    public function __construct(){
        $this->connection();
    }
    public function connection(){
        $this->connection = new mysqli($this->db_host,
                $this->db_user,
                $this->db_pass,
                $this->db_name);
        if($this->connection->connect_error){
            die("Error de conexion: " . $this->connection->connect_error);
        }
    }

    public function query($sql){
        /*fetch_assoc trae solo la primera busqueda, como clave valor, pero con el all trae todos
        solo hay que transformarla para que sea asociativa*/
        $this->query = $this->connection->query($sql);
        return $this;
    }

    public function first(){
        return $this->query->fetch_assoc();
    }

    public function get(){
        return $this->query->fetch_all(MYSQLI_ASSOC);
    }
}