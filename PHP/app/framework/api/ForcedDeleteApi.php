<?php
namespace app\framework\api;

require_once(dirname(__FILE__,2) . '/exception/NullPointerException.php');
require_once(dirname(__FILE__,1) . '/InsertableApi.php');

abstract class ForcedDeleteApi extends InsertableApi implements Delete{



    public function __construct(String $delete = null){
        $this->delete = (null !== $_GET['delete'] ? $_GET['delete'] : $delete);
        parent::__construct();

        if($this->delete !== null && $this->testing === false){
            $this->delete();
            $this->executed = true;
        }
    }

    public function delete(){
        try{
            $model = $this->createDeleteModel();
            $code = $this->database->delete($model);
            $code = substr($code, 0, 2);
            parent::setHttpCode($code);
        }catch(\PDOException $e){
            parent::setHttpCode($e->getCode());
        }catch(\app\framework\exception\NullPointerException $e){
            header('HTTP/1.0 400 Bad Request');
            //return the error code for easy debug
            echo json_encode($e->getMessage());
            restore_error_handler();
        }
    }

    public function createDeleteModel() : \model\Model{
      $model = $this->createModel();
      //I don't know how to get the decoded arguments to the database, so I will call rebuildArguments again
      if(null != $this->delete){
          $arguments = parent::rebuildArguments($this->delete);
          foreach($arguments as $value){
              $this->bindModel($model, $value);
          }
      }
      return $model;
    }

    abstract public function createModel() : \app\framework\model\Model;
    abstract public function createDatabase() : \app\framework\database\CRUD;
    abstract public function bindModel(\app\framework\model\Model $model, Array $value) : \app\framework\model\Model;

}
