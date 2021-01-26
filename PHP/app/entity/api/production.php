<?php
namespace app\entity\api;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/api/InsertableApi.php');
require_once(dirname(__FILE__,3) . '/entity/model/Production.php');
require_once(dirname(__FILE__,3) . '/entity/database/Production.php');

class Production extends \app\framework\api\InsertableApi{
    public function __construct(){
        parent::__construct();
    }

    public function getFields() : array{
        return [['animal'], ['production'], ['product'], ['productiondate'], ['productiontime']];
    }

    public function getUpdateableFields() : array{
        return [];
    }

    public function createModel() : \app\framework\model\Model {
        return new \app\entity\model\Production();
    }

    public function createDatabase() : \app\framework\database\CRUD{
        return new \app\entity\database\Production();
    }

    public function bindModel(\app\framework\model\Model $model, Array $value) : \app\framework\model\Model{
          switch($value[0]){
              case 'animal':
                $model->setAnimal(end($value));
                break;
              case 'production':
                $model->setProduction(end($value));
                break;
              case 'product':
                $model->setProduct(end($value));
                break;
              case 'productiondatetime':
                $date = \DateTime::createFromFormat('Y-m-d H:i:s', end($value));
                $model->setProductionDatetime($date);
                break;
          }
        return $model;
    }
}
$api = new \app\entity\api\Production();
$api->checkIfExecuted();
?>
