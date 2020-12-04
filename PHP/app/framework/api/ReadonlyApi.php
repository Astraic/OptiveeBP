<?php
namespace app\framework\api;

require_once(dirname(__FILE__,2) . '/exception/NullPointerException.php');
require_once(dirname(__FILE__,1) . '/Read.php');
require_once(dirname(__FILE__,1) . '/Api.php');

abstract class ReadonlyApi extends Api implements Read{

  public function __construct(String $select = null, String $where = null, String $order = null, String $json = null){

      set_error_handler(array($this, 'error_handler'));
      $this->database = $this->createDatabase();
      header('Content-Type: application/json');

      $this->where = (null !== $_GET['where'] ? $_GET['where'] : $where);
      $this->select = (null !== $_GET['select'] ? $_GET['select'] : $select);
      $this->order = (null !== $_GET['order'] ? $_GET['order'] : $order);
      $this->json = (false != file_get_contents('php://input') ? file_get_contents('php://input') : $json);

      if($this->json === null && $this->delete === null ){
          $this->select();
      }
      parent::__construct();
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
  abstract public function getFields() : array;
}
