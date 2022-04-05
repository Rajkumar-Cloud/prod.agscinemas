<?php

/*
    Author:- AGS Cinemas
    Date:- 08-12-2021
    Purpose:- Creating connetion to the Database.
*/

class Database {
 
    // specify your own database credentials
    private $host = "localhost";            //Server
    private $db_name = "agscinem_dev";      //Database Name
    private $username = "root";             //UserName of Phpmyadmin
    private $password = "Ags@123.";        //Password associated with username
    public $conn;
     
    // get the database connection
    public function getConnection() { 
        $this->conn = null; 
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>