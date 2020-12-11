<?php
namespace app\framework\api;

require_once(dirname(__FILE__,2) . '/exception/NullPointerException.php');
require_once(dirname(__FILE__,1) . '/Update.php');
require_once(dirname(__FILE__,1) . '/ReadonlyApi.php');

abstract class ForcedApi extends ReadonlyApi implements Update {

    protected $whereRequired;

    public function __construct(String $select = null, String $where = null, String $order = null, String $json = null){
        parent::__construct();

        if($this->json !== null && $this->where !== null && $this->testing === false){
            $this->update();
        }
    }

    public function update(){
      try{
          $modelOld = $this->createWhereModel();
          $modelNew = $this->createFilledModel();

          $queryBuilderUpdate = parent::buildUpdate($modelNew);
          $queryBuilderSelect = parent::buildQuery($modelOld);

          $this->database->addSelectStatement($queryBuilderSelect, $queryBuilderUpdate);

          $result = $this->database->select($modelOld);

          if(count($result[1][0]) == 1){
              $resultUpdate = $this->database->update($modelNew, $modelOld);
              parent::setHttpCode($resultUpdate);
          }else{
              throw new \app\framework\exception\NullPointerException("The request changed more than one record, please change your where scope");
          }

      }catch(\PDOException $e){
          parent::setHttpCode($e->getCode());
      }catch(\app\framework\exception\NullPointerException $e){
          header('HTTP/1.0 400 Bad Request');
          //set the datatype to json for consistancy with all select query's
          //return the error code for easy debug
          echo json_encode($e->getMessage());
          restore_error_handler();
      }
    }


        function createFilledModel() : \app\framework\model\Model {
          if(isset($this->json)){
              $model = $this->createModel();
              $arguments = parent::rebuildArgumentsFromJson($this->json);
              foreach($arguments as $value){
                  $model = $this->bindModel($model, $value);
              }
          }else{
              throw new \app\framework\exception\NullPointerException("No JSON was passed to the API");
          }
          return $model;
        }

    abstract public function createModel() : \app\framework\model\Model;
    abstract public function createDatabase() : \app\framework\database\CRUD;
    abstract public function bindModel(\app\framework\model\Model $model, Array $value) : \app\framework\model\Model;
    abstract public function getFields() : array;
    abstract public function getUpdateableFields() : array;
}
?>
