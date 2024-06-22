<?php
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '../errors.log');
class Database
{
    // Database connection settings
    private $dbhost = 'localhost';
    private $dbname = 'children';
    private $dbusername = 'root';
    private $dbpassword = '';
    private $conn;

    public function __construct()
    {
        // Create a new PDO instance
        $this->conn = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname", $this->dbusername, $this->dbpassword);
        
        // Set the PDO error mode to exception
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function select($sql, $fetch, $params)
    {
        // Prepare and bind
        $stmt = $this->conn->prepare($sql);

        // Execute the prepared statement
        $res = $stmt->execute($params);
        if ($res && $fetch)
        {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $stmt;
    }

    public function selectAll($sql, $fetch, $params){
        $stmt = $this->conn->prepare($sql);

        // Execute the prepared statement
        $res = $stmt->execute($params);
        if ($res && $fetch)
        {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $stmt;
    }

    public function execute($sql, $params)
    {
        // Prepare and bind
        $stmt = $this->conn->prepare($sql);

        // Execute the prepared statement
        $result = $stmt->execute($params);
        return  $result;
    } 
}
?>