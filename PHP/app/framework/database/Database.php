<?php
namespace app\framework\database;
class Database extends \PDO{
    private static $instance = null;

    public static function getConnection() : \app\framework\database\Database{
       if(self::$instance == null){
          $instance = new \app\framework\database\Database();
       }
       return $instance;
    }

    public function __construct(){
        parent::__construct("sqlsrv:Server=optivee-server.germanywestcentral.cloudapp.azure.com;Database=optiveedb", "Thijs", "Thijs123!");
        //parent::__construct("mysql:host=localhost;dbname=beroepsproduct;charset=utf8", "admin", "");
        parent::setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, false);
        parent::setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }
}
?>
