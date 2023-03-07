<?php

namespace App\Models;

use mysqli;

class Model{
    protected $db_host  =   DB_HOST;
    protected $db_user  =   DB_USER; 
    protected $db_pass  =   DB_PASS; 
    protected $db_name  =   DB_NAME; 

    protected $connection;
    protected $query;

    protected $table;

    public function __construct()
    {
        $this->connection();
    }
    public function connection(){
        
        $this->connection= new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
        if($this->connection->connect_error){
            die('Error de conexion:');
        }

    }
    public function query($sql, $data = [], $params = null){
        // ->fetch_all(MYSQLI_ASSOC) // todos los datos
      if($data){
         if(!$params){
            // $params = str
            
         }
         $stmt = $this->connection->prepare($sql);
         $stmt->bind_param($params,...$data);
         $stmt->execute();
         $this->query = $stmt->get_result();
      }else{
         $this->query= $this->connection->query($sql);
      }
      return $this;
    }

    public function first(){
        return $this->query->fetch_assoc();
    }
    public function get(){
        return $this->query->fetch_all(MYSQLI_ASSOC);
    }

     // Consultas
     public function all(){
        $sql= "SELECT * FROM {$this->table}";
        return $this->query($sql)->get();
     }

     public function find($id){
        $sql = "SELECT * FROM {$this->table} WHERE id = {$id}";
        return $this->query($sql)->first();
     }

     /**
      * @param string $column Columna de la tabla -> "name"
      * @param string $operator Columna de la tabla -> "value" | ">"
      * @param string|null $value Columna de la tabla -> "value"
      */ 
     public function where(string $column,$operator,$value=null){
        
        if($value == null){
            $value=$operator;
            $operator = "=";
        }
        
        /* evitar inyeccion sql no tan recomendada
         $value= $this->connection->real_escape_string($value);
         $sql = "SELECT * FROM {$this->table} WHERE {$column} {$operator} '$value'";*/
        
        $sql = "SELECT * FROM {$this->table} WHERE {$column} {$operator} ?";
        
       
        return $this;
     }


     public function create($data){
        
        $columns = implode(", ",array_keys($data));
        $values ="'". implode("', '",array_values($data))."'";
         
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";
        
        $this->query($sql);

        $id = $this->connection->insert_id;
        
        return $this->find($id);
     }
     
     public function update($id,$data){
        
        $fields =[];
        foreach ($data as $key => $value) {
           $fields[]="{$key} = '{$value}'";
        }
        $fields= implode(", ",$fields);
        
        $sql = "UPDATE {$this->table} SET  $fields where id = {$id}";
        
        $this->query($sql);
        
        return $this->find($id);
     }

     public function delete($id){
        $sql = "DELETE FROM {$this->table} WHERE id = {$id}";
        $this->query($sql);
     }
    
}      
?>