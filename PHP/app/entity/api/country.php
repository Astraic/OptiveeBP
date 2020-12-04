<?php
namespace app\entity\api;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/api/ForcedApi.php');
require_once(dirname(__FILE__,3) . '/entity/model/Country.php');
require_once(dirname(__FILE__,3) . '/entity/database/Country.php');

class Country extends \app\framework\api\ForcedApi{
    public function __construct(){
        parent::__construct();
    }

    public function getFields() : array{
        return [['code'], ['name']];
    }

    public function getUpdateableFields() : array{
        return [['code'], ['name']];
    }

    public function createModel() : \app\framework\model\Model {
        return new \app\entity\model\Country();
    }

    public function createDatabase() : \app\framework\database\CRUD{
        return new \app\entity\database\Country();
    }

    public function bindModel(\model\Model $model, Array $value) : \app\framework\model\Model{
          switch($value[0]){
              case 'code':
                  $model->setCode(end($value));
                  break;
              case 'name':
                  $model->setName(end($value));
                  break;
          }
        return $model;
    }
}
$api = new \app\entity\api\Country();
?>
