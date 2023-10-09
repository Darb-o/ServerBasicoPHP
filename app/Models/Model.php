<?php

namespace App\Models;
use mysqli;
class Model{
    protected $db_host = DB_HOST;
    protected $db_user = DB_USER;
    protected $db_pass = DB_PASS;
    protected $db_name = DB_NAME;

    protected $connection;
    protected $query;

    protected $table;

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

    /*consulta en la tabla desde el cual se invoque, al ser heredada si se instancia
    un model de otra tabla el valor de esta tabla tendra el nombre de la tabla*/
    public function all(){
        $sql = "select * from {$this->table}";
        return $this->query($sql)->get();
    }
    //encontrar un registro en especifico
    public function find($id){
        $sql = "select * from {$this->table} where id = {$id}";
        return $this->query($sql)->first();
    }

    /*permite buscar por una columna especifica, con un valor especifico, pero a su vez 
    el filtro con el operador <>=*/
    public function where($column,$operator,$value=null){
        //verifica si existe el tercer argumento
        if($value == null){
            $value = $operator;
            $operator = '=';   
        }
        $sql = "select * from {$this->table} where {$column} {$operator} '{$value}'";
        $this->query($sql);
        return $this;
    }

    //insercion
    public function create($data){
        //array que extrae solo las llaves del array
        $columns = array_keys($data);
        //separa el array con dicho formato
        $columns = implode(',',$columns);
        $values = array_values($data);
        //da formato para que la informacion quede entre comillas
        $values = "'".implode("','",$values)."'";
        $sql = "insert into {$this->table} ({$columns}) values ({$values})";
        $this->query($sql);
        //retorna el ultimo id insertado
        $insert_id = $this->connection->insert_id;
        return $this->find($insert_id);
    }

    //update
    public function update($id, $data){
        //recibe la informacion y la copea, luego la separa por comas y hacer la consulta
        $fields = [];
        foreach($data as $key => $value){
            $fields[] = "{$key} = '{$value}'";
        }
        $fields = implode(', ',$fields);
        $sql = "update {$this->table} set {$fields} where id = {$id}";
        $this->query($sql);
        return $this->find($id);
    }

    //delete
    public function delete($id){
        $sql = "delete from {$this->table} where id = {$id}";
    }
}