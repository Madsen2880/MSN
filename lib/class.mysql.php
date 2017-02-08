<?php

class dbconnector {
    const SERVER = 'localhost';
    const USERNAME = 'root';
    const PASSWORD = '';
    const DATABASE = 'mysocialnetwork';

    private function newPDOConn(){
         try{
            $PDOConn = new PDO("mysql:host=".self::SERVER.";dbname=".self::DATABASE, self::USERNAME, self::PASSWORD, array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_TIMEOUT => 10,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ));
            return $PDOConn;
        }catch(PDOExecption $err){
            $PDOConn = null;
            echo 'Connection failed: ' . $err->getMessage();
        }
    }
    public function testConnection(){
        try{
            $conn = $this->newPDOConn();
            echo "Connection is working fine to server: " . self::SERVER;
        }catch(PDOExecption $err){
            $conn = null;
            echo 'Connection failed: ' . $err->getMessage();
        }
    }

    public function newQuery($input){
         try{
            $conn = $this->newPDOConn();
            $query = $conn->prepare($input);

            return $query;
         }catch(PDOException $e){
             echo $e->getMessage();
         }
    }
}
