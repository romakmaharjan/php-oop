<?php 

class Database{

    private $_conn;
    private static $_instance;

    private function __construct(){
      $this->Connection();
    }

    private function Connection(){
        try{
        $this->_conn = new PDO("mysql:host=localhost;dbname=phpoop", "root", "");
        $this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }
    }

public static function Instance(){
        if(!self::$_instance){
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    public function Insert($tableName,$data=[]){
        if(empty($tableName) || empty($data)) throw new Exception('Table name and data required');
        $columns = implode(',',array_keys($data));
        $arrayValues=array_values($data);
        $setQM="";
        for($i=0;$i<count($data);$i++){
            $setQM.='?,';
        }
        $setQM=rtrim($setQM,',');        
        $sql="INSERT INTO $tableName($columns)VALUES($setQM)";
        $preStatement = $this->_conn->prepare($sql);
        try{
            $preStatement->execute($arrayValues);   
            return $this->_conn->lastInsertId();
        }catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }
      
    }
}

?>