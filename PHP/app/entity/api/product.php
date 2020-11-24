<?php
namespace app\entity\api;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/api/ForcedApi.php');
require_once(dirname(__FILE__,3) . '/entity/model/Product.php');
require_once(dirname(__FILE__,3) . '/entity/database/Product.php');

class Product extends \app\framework\api\ForcedApi{
    public function __construct(){
        parent::__construct();
    }

    public static function getFields() {
        return [['product']];
    }

    public static function getUpdateableFields(){
        return [['product']];
    }

    public function createModel() : \app\framework\model\Model {
        return new \app\entity\model\Product();
    }

    public function createDatabase() : \app\framework\database\CRUD{
        return new \app\entity\database\Product();
    }

    public function bindModel(\app\framework\model\Model $model, Array $value) : \app\framework\model\Model{
          switch($value[0]){
              case 'product':
                  $model->setProduct(end($value));
                  break;
          }
        return $model;
    }
}
$api = new \app\entity\api\Product();
?>
