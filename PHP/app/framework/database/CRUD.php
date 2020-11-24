<?php
namespace app\framework\database;
class CRUD {
    protected $select = array();
    protected $insert;
    protected $update = array();
    protected $delete;

    public function __construct($query = null){}

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
          var_dump(get_class($query));
          var_dump($query);
            //first condition serves for unit testing with mock objects, second condition for prod enviorment
            if(substr(substr(get_class($query), 4), 1,  -9) === 'QueryBuilder' || get_class($query) === 'app\framework\database\QueryBuilder'){
                $this->select[] = Database::getConnection()->prepare($query->getSql());
            }else{
                $this->update[] = Database::getConnection()->prepare($query->getSql());
            }

            var_dump($this->select);
        }
    }
}
