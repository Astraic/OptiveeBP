<?php
namespace app\entity\api;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/api/ForcedApi.php');
require_once(dirname(__FILE__,3) . '/entity/model/Animal.php');
require_once(dirname(__FILE__,3) . '/entity/database/Animal.php');

class NewAnimal extends \app\framework\api\ForcedApi{
    public function __construct(){
        parent::__construct();
    }

    public static function getFields() {
        return [['id'], ['nfc']];
    }

    public static function getUpdateableFields(){
        return [['nfc']];
    }


    public function createModel() : \app\framework\model\Model {
        return new \app\entity\model\Animal();
    }

    public function createDatabase() : \app\framework\database\CRUD{
        return new \app\entity\database\Animal();
    }

    public function bindModel(\app\framework\model\Model $model, Array $value) : \app\framework\model\Model{
          switch($value[0]){
              case 'id':
                $model->setId(end($value));
                break;
              case 'nfc':
                $model->setNfc(end($value));
                break;
          }
        return $model;
    }
}
$api = new \app\entity\api\NewAnimal();
?>
