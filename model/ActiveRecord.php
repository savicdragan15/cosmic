<?php
abstract class ActiveRecord{
	public static function getAll($filter = "",$fields='*') {
        try {
            $db = DataBase::getInstance();
            $conn = $db->conn;
            //echo 'Connected to database<br />';
            $sql = "SELECT ". $fields ." FROM " . static::$table . " " . $filter;
            /*             * * fetch into an PDOStatement object ** */
            // echo $sql; exit;
            $res = $conn->query($sql);
            return $res->fetchAll(PDO::FETCH_CLASS, get_called_class());
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
/*****************************************************************/
public static function get($id){
      try {
            $db = DataBase::getInstance();
            $conn = $db->conn;
            //echo 'Conected to database <br />';
            $sql = ("SELECT * FROM " . static::$table . " WHERE " . static::$key . "=" . $id);
            echo $sql;
            $rez = $conn->query($sql);
            return $row = $rez->fetchObject(get_called_class());
            echo $sql;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } 
/*************************************************************/ 
public function save(){
        //instaciranje Signelton koneckcije
        $db = DataBase::getInstance();
        //pristupanje objektu conn
        $conn = $db->conn;
        //upit
        $q = "UPDATE " . static::$table . " SET ";
        //preuzimanje polja iz baze podataka
        $polja_arr = get_object_vars($this);
        foreach ($polja_arr as $key => $value) {
            if ($key == static::$key)
                continue;
            $q.= $key . "='" . $value . "',";
        }
        $q = rtrim($q, ",");
        $keyString = static::$key;
        $q.= " WHERE " . $keyString . " = " . $this->$keyString;

        //echo $q . "<br>";
        return $count = $conn->exec($q);
        //  $count = $conn->exec("UPDATE users SET name='$this->name', password='$this->password' WHERE id='$this->id'");
        //echo "New record created successfully."."<br>";
        //echo $count . "<br>"; 
    }	  
/*******************************************************************/
public  function insert(){
    $db = DataBase::getInstance();
        $conn = $db->conn;
        //echo 'Connected to database<br />';
        //echo $conn;
        $q = "INSERT INTO " . static::$table . " ";
        //$q.= static::$table;
        $polja_arr = get_object_vars($this);
        $polja = array_keys($polja_arr);
        $q.= "(" . implode(",", $polja) . ") VALUES ";
        $q.= "('";
        $q.= implode("','", array_values($polja_arr));
        $q.="')";
        //echo $q;
        return $conn->exec($q);
        //echo $conn->lastInsertId();
//$count = $conn->exec("INSERT INTO users(name, password) VALUES ('$this->name', '$this->password')");
//echo "New record created successfully. Last inserted ID is: ". $conn->lastInsertId() ."<br>";
//echo $count;
   }
   
    public function delete($id){
        $db = DataBase::getInstance();
        $conn = $db->conn;
        $query = "DELETE from " .  static::$table . " WHERE " . static::$key . "={$id}";
        return $conn->exec($query);
    }
}


