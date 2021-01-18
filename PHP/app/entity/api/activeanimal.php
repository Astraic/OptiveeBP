<?php
namespace app\entity\api;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/api/InsertableApi.php');
require_once(dirname(__FILE__,3) . '/entity/model/Animal.php');
require_once(dirname(__FILE__,3) . '/entity/database/Animal.php');

class ActiveAnimal extends \app\framework\api\InsertableApi{
    public function __construct(){
        parent::__construct();
    }

    public function createModel() : \app\framework\model\Model {
        return new \app\entity\model\Animal();
    }

    public function createDatabase() : \app\framework\database\CRUD{
        return new \app\entity\database\Animal();
    }

    public function getFields() : array{
        return [['id'], ['nfc'], ['country'], ['serial'], ['working'], ['control'], ['product'], ['environment']];
    }

    public function getUpdateableFields() : array{
        return [['reasonofdeath'], ['passdate']];
    }

    public function bindModel(\app\framework\model\Model $model, Array $value) : \app\framework\model\Model{
          switch($value[0]){
              case 'id':
                $model->setId(end($value));
                break;
              case 'nfc':
                $model->setNfc(end($value));
                break;
              case 'country':
                $model->setCountry(end($value));
                break;
              case 'serial':
                $model->setSerial(end($value));
                break;
              case 'working':
                $model->setWorking(end($value));
                break;
              case 'control':
                $model->setControl(end($value));
                break;
              case 'product':
                $model->setProduct(end($value));
                break;
              case 'enviroment':
                $model->setEnviroment(end($value));
                break;
              case 'reasonofdeath':
                $model->setReasonofdeath(end($value));
                break;
              case 'passdate':
                $date = \DateTime::createFromFormat('Y-m-d', end($value));
                $model->setPassdate($date);
                break;
          }
        return $model;
    }
}
$api = new \app\entity\api\ActiveAnimal();
$api->checkIfExecuted();
?>
