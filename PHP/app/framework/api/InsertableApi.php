<?php
namespace app\framework\api;

require_once(dirname(__FILE__,2) . '/exception/NullPointerException.php');
require_once(dirname(__FILE__,1) . '/Write.php');
require_once(dirname(__FILE__,1) . '/ForcedApi.php');

abstract class InsertableApi extends ForcedApi implements Write{

    public function __construct(String $select = null, String $where = null, String $order = null, String $json = null){
        parent::__construct();

        if($this->json !== null && $this->where === null && $this->testing === false){
            $this->insert();
        }
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

    abstract public function createModel() : \app\framework\model\Model;
    abstract public function createDatabase() : \app\framework\database\CRUD;
    abstract public function bindModel(\app\framework\model\Model $model, Array $value) : \app\framework\model\Model;
    abstract public function getFields() : array;
    abstract public function getUpdateableFields() : array;
}
?>
