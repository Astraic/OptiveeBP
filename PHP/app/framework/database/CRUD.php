<?php
namespace app\framework\database;
require_once(dirname(__FILE__, 4) . '/app/framework/database/Database.php');
class CRUD {
    protected $select = array();
    protected $insert;
    protected $update = array();
    protected $delete;

    public function __construct(){}

    public function addSelectStatement(QueryBuilderParent ...$query){
        if(gettype($query) ===  'array'){
            foreach($query as $value){
                $this->assignStatement($value);
            }
        }else{
            $this->assignStatement($query);
        }
    }

    public function assignStatement(QueryBuilderParent $query){
        $query->generateSql();
        if($query->getSql() != null){
            //first condition serves for unit testing with mock objects, second condition for prod enviorment
            if(substr(substr(get_class($query), 4), 1,  -9) === 'QueryBuilder' || get_class($query) === 'app\framework\database\QueryBuilder'){
                $this->select[] = Database::getConnection()->prepare($query->getSql());
            }else{
                $this->update[] = Database::getConnection()->prepare($query->getSql());
            }
        }
    }
}
