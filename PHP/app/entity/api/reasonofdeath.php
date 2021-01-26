<?php
namespace app\entity\api;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/api/InsertableApi.php');
require_once(dirname(__FILE__,3) . '/entity/model/Reasonofdeath.php');
require_once(dirname(__FILE__,3) . '/entity/database/Reasonofdeath.php');

class Reasonofdeath extends \app\framework\api\InsertableApi{
    public function __construct(){
        parent::__construct();
    }

    public function getFields() : array {
        return [['reasonofdeath']];
    }

    public function getUpdateableFields() : array{
        return [];
    }

    public function createModel() : \app\framework\model\Model {
        return new \app\entity\model\ReasonOfDeath();
    }

    public function createDatabase() : \app\framework\database\CRUD{
        return new \app\entity\database\ReasonOfDeath();
    }

    public function bindModel(\app\framework\model\Model $model, Array $value) : \app\framework\model\Model{
          switch($value[0]){
              case 'reasonofdeath':
                  $model->setReasonofdeath(end($value));
                  break;
          }
        return $model;
    }
}
$api = new \app\entity\api\ReasonOfDeath();
$api->checkIfExecuted();
?>
