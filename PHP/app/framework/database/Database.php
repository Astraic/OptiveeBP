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
        parent::__construct("sqlsrv:Server=optivee-server.germanywestcentral.cloudapp.azure.com;Database=optiveedb", "applicationapi", '5L#e7&*NQ!%J@eu$XRmJv7idDo9YS3xw#haE');
        parent::setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, false);
        parent::setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }
}
?>
