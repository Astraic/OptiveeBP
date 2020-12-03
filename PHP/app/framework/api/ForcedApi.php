<?php
namespace app\framework\api;

require_once(dirname(__FILE__,2) . '/exception/NullPointerException.php');
require_once(dirname(__FILE__,1) . '/CRUInterface.php');
require_once(dirname(__FILE__,1) . '/Api.php');

abstract class ForcedApi extends Api implements CRUInterface{

    protected $whereRequired;

    public function __construct(String $select = null, String $where = null, String $order = null, String $json = null){

        set_error_handler(array($this, 'error_handler'));
        $this->database = $this->createDatabase();
        header('Content-Type: application/json');

        $this->where = (null !== $_GET['where'] ? $_GET['where'] : $where);
        $this->select = (null !== $_GET['select'] ? $_GET['select'] : $select);
        $this->order = (null !== $_GET['order'] ? $_GET['order'] : $order);
        $this->json = (false != file_get_contents('php://input') ? file_get_contents('php://input') : $json);

        if($this->json === null){
            $this->select();
        }else if($this->where === null){
            $this->insert();
        }else if($this->where !== null){
            $this->update();
        }



        parent::__construct();
    }

    public function insert(){
      try{
          //load all get parameters into the model
          $model = $this->createFilledModel();
          //insert the model into the db
          $code = $this->database->insert($model);
          //get the class code from the full error code
          $code = substr($code, 0, 2);

          //set the http status code and die
          parent::setHttpCode($code);

      }catch(\PDOException $e){
          //set the http status code and die
          parent::setHttpCode($e->getCode());
      }catch(\app\framework\exception\NullPointerException $e){
          header('HTTP/1.0 400 Bad Request');
          //return the message for easy debug
          echo $e->getMessage();
          restore_error_handler();
      }
    }

    public function select(){
      try{
          //rebuild the get parameters in useful queries
          $model = $this->createWhereModel();
          $queryBuilder = parent::buildQuery($model);
          $this->database->addSelectStatement($queryBuilder);

          //execute the select statement and get the code and result object
          $codeAndResult = $this->database->select($model);
          $code = substr($codeAndResult[0], 0, 2);

          //if the query was succesful return the data
          if($code === '00'){
              header('Content-Type: application/json');
              echo json_encode($codeAndResult[1][0]);
          }

          parent::setHttpCode($code);
        }catch(\PDOException $e){
            parent::setHttpCode($e->getCode());
        }catch(\app\framework\exception\NullPointerException $e){
            header('HTTP/1.0 400 Bad Request');
            //return the message for easy debug
            echo json_encode($e->getMessage());
            restore_error_handler();
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

    function createWhereModel() : \app\framework\model\Model{
        $model = $this->createModel();
        //I don't know how to get the decoded arguments to the database, so I will call rebuildArguments again
        if(null != $this->where){
            $arguments = parent::rebuildArguments($this->where);
            foreach($arguments as $value){
                $this->bindModel($model, $value);
            }
        }else if($this->whereRequired){
            throw new \app\framework\exception\NullPointerException("This entity requires an where clause");
        }
        return $model;
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

    function error_handler($errno, $errstr, $errfile, $errline){
        $errstr = substr($errstr, 17);
        if($errstr == 'select' || $errstr == 'where' || $errstr == 'order'){
            return;
        }else{
            restore_error_handler();
        }
    }

    abstract public function createModel() : \app\framework\model\Model;
    abstract public function createDatabase() : \app\framework\database\CRUD;
    abstract public function bindModel(\app\framework\model\Model $model, Array $value) : \app\framework\model\Model;
}


?>
