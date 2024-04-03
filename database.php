<?php
class Database
{
    private $_conn;
    private static $_instance;
    private function __construct()
    {
        $this->Connection();
    }
    private function Connection()
    {
        try {
            $this->_conn = new PDO("mysql:host=localhost;dbname=phpoop", "root", "");
            $this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public static function Instance()
    {
        if (!self::$_instance) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

public function Insert($tableName, $data = [])
    {
        if (empty($tableName) || empty($data)) {
            throw new Exception('Table name and data required');
        }

        $columns = implode(',', array_keys($data));
        $arrayValues = array_values($data);
        $setQM = "";
        for ($i = 0; $i < count($data); $i++) {
            $setQM .= '?,';
        }
        $setQM = rtrim($setQM, ',');
        $sql = "INSERT INTO $tableName($columns)VALUES($setQM)";
        $preStatement = $this->_conn->prepare($sql);
        try {
            $preStatement->execute($arrayValues);
            return $this->_conn->lastInsertId();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }

public function Update($tableName, $data = [], $criteria = '', $bindValue='')
    {
        if (empty($tableName)  || empty($data) ||  empty($criteria) || empty($bindValue)) {
            throw new Exception('Table name and data and criteria required');
        }

        $mergeData=array_merge(array_values($data),[$bindValue]);
        $setQM = "";
        $i = 1;
        foreach ($data as $key => $value) {
            $setQM .= $key . '=?';
            if ($i < count($data)) {
                $setQM .= ',';
            }
            $i++;
        }
        $sql = "UPDATE $tableName SET $setQM WHERE $criteria=?";
        $preStatement = $this->_conn->prepare($sql);
        try {
            return $preStatement->execute($mergeData);
            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

public function Delete($tableName,$criteria,$bindValue){
        if (empty($tableName) || empty($criteria)) {
            throw new Exception('Table name and criteria required');
        }

        $sql="DELETE FROM $tableName WHERE $criteria=?";
        $preStatement = $this->_conn->prepare($sql);
        try{
            return $preStatement->execute([$bindValue]);
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }      

    }

    public function All($tableName){
        if (empty($tableName)) {
            throw new Exception('Table name required');
        }

        $sql="SELECT * FROM $tableName";
        $preStatement = $this->_conn->prepare($sql);
        try{
            $preStatement->execute([]);
             return ($preStatement->fetchAll(PDO::FETCH_CLASS));             
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }

    public function SelectByCriteria($tableName = '', $column = '*', $criteria = '', $bindValue = array(), $clause = '')
    {
           if (empty($tableName)) throw new PDOException('table name is required');
        if (empty($column)) {
            $column .= '*';
        }
        $query = "SELECT {$column} FROM {$tableName}";
        if (!empty($criteria)) {
            $query .= " WHERE {$criteria}=?";
        }
        if (!empty($clause)) {
            $query .= " " . $clause;
        }
        $prepareStatement = $this->_conn->prepare($query);
        try {
            if ($prepareStatement->execute($bindValue)) {
                return $prepareStatement->fetchAll(PDO::FETCH_CLASS);
            }

        } catch (PDOException $exception) {
            die($exception->getMessage());
        }

        return false;
        }  
    public function Query($query = '')
    {
        if (empty($query)) throw new PDOException('Query field is required');
        $prepareStatement = $this->_conn->prepare($query);

        try {
            if ($prepareStatement->execute([])) {
                return $prepareStatement->fetchAll(PDO::FETCH_CLASS);
            }

        } catch (PDOException $exception) {
            die($exception->getMessage());
        }

        return false;


    }
    public function Count($tableName = '', $column = '*', $criteria = '', $bindValue = array())
    {
        if (empty($tableName)) throw new PDOException('Table name is required');
        $query = "SELECT COUNT($column) COUNT FROM {$tableName}";
        if (!empty($criteria) && !empty($bindValue)) {
            $query .= " WHERE {$criteria}=?";
        }
        $prepareStatement = $this->_conn->prepare($query);
        try {
            if ($prepareStatement->execute($bindValue)) {
                $result = $prepareStatement->fetchAll(PDO::FETCH_COLUMN);
                if ($result) {
                    return $result[0];
                }
                return $result;
            }

        } catch (PDOException $exception) {
            die($exception->getMessage());
        }

        return false;
    }
}