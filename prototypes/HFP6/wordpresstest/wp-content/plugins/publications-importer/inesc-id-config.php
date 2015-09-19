<?php
class db{

private static $instance = NULL;


private function __construct() {
}


public static function getInstance() {

if (!self::$instance)
    {
    self::$instance = new PDO("mysql:host=www-db.inesc-id.pt;dbname=INESC", "dblist", "db2004ac1", array(PDO::ATTR_PERSISTENT => true)); 
    self::$instance-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    self::$instance-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
return self::$instance;
}


private function __clone(){
}

}        
      
?>
