<?php
include_once(MAIN_PATH . '/env.php');
class Database
{
    
    private $connection;
    private $host=DB_HOST;
    private $username =DB_USER;
    private $password=DB_PASSWORD;
    private $database= DB_NAME;
    public function __construct()
    {

        $this->connect($this->host, $this->username, $this->password, $this->database);
    }


    private function connect($host, $username, $password, $database)
    {
        $this->connection = new mysqli($host, $username, $password, $database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public  function insert($table, $data)
    {
        if (empty($table) || !is_array($data) || empty($data)) {

            $this->showError("invalid input for insert");
            return false;
        }
        $columns = implode(",", array_keys($data));
        $values = "'" . implode("','", array_values($data)) . "'";
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
       
        if ($this->connection->query($sql)) {
            return true;
        } else {
            $this->showError($this->connection->error);
            return false;
        }
    }

    public function update($table, $data, $condition)
    {
        if (empty($table) || !is_array($data) || empty($data) || empty($condition) || !is_array($condition)) {

            $this->showError("invalid input for update");
            return false;
        }



        $setClouse = '';
        foreach ($data as $column => $value) {

            $setClouse .= "$column = '$value' ,";
        }
        $setClouse = rtrim($setClouse, ',');

        $whereClouse = '';
        foreach ($condition as $column => $value) {

            $whereClouse .= "$column = '$value' AND";
        }
        $whereClouse = rtrim($whereClouse, 'AND');


        $sql = "UPDATE {$table} SET {$setClouse} WHERE {$whereClouse}";
        // echo $sql;
        // die;
        if ($this->connection->query($sql)) {
            return true;
        } else {
            $this->showError($this->connection->error);
            return false;
        }
    }

    public function delete($table, $condition)
    {
        if (empty($table) ||  empty($condition) || !is_array($condition)) {

            $this->showError("invalid input for delete ");
            return false;
        }
        $whereClouse = '';
        foreach ($condition as $column => $value) {

            $whereClouse .= "$column = '$value' AND";
        }
        $whereClouse = rtrim($whereClouse, 'AND');

        $sql = "DELETE  FROM {$table} WHERE {$whereClouse}";
       
        if ($this->connection->query($sql)) {
            return true;
        } else {
            $this->showError($this->connection->error);
            return false;
        }
    }

    public function getRow($table, $condition)
    {
        if (empty($table) ||  empty($condition) || !is_array($condition)) {

            $this->showError("invalid input for get row ");
            return false;
        }
        $whereClouse = '';
        foreach ($condition as $column => $value) {

            $whereClouse .= "$column = '$value' AND";
        }
        $whereClouse = rtrim($whereClouse, 'AND');
        $sql = "SELECT * FROM {$table} WHERE {$whereClouse}";
       
        $result = $this->connection->query($sql);
        if (!$result) {
            $this->showError($this->connection->error);
            return null;
        }


        return $result->fetch_assoc();
    }

    public function lastInsertedID()
    {
        return $this->connection->insert_id;
    }

    public function getAll($table)
    {
        if (empty($table)) {

            $this->showError("invalid input for get all ");
            return false;
        }

        $sql = "SELECT  * FROM {$table} ";
        $result = $this->connection->query($sql);
        if (!$result) {
            $this->showError($this->connection->error);
            return null;
        }

        $data = [];
        while ($row =  $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function close()
    {
        $this->connection->close();
    }

    public function showConnectionError()
    {
        return $this->connection->connect_error;
    }

    public  function showError($error)
    {
        return "Erorr:" . $error;
    }

    function __destruct(){
        if($this->connection){
            $this->close();
        }
    }
}
