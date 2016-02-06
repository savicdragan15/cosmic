<?php
class Database{
    private static $instance = null;
    public $conn;
    //privatni konstrukt ne dozvoljava instancireanje klase vise od jednog puta
    private function __construct() {
        $this->conn = new PDO("mysql:host=localhost;dbname=cosmic;charset=utf8;","root","");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new Database();
        }
        return self::$instance;
    }
}