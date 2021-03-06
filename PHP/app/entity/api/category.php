<?php
namespace app\entity\api;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/api/InsertableApi.php');
require_once(dirname(__FILE__,3) . '/entity/model/Category.php');
require_once(dirname(__FILE__,3) . '/entity/database/Category.php');

/**
 * API ter behoeve van framework voor category model class.
 * @author Stephan de Jongh
 */

class Category extends \app\framework\api\InsertableApi {
    public function __construct(){
        parent::__construct();
    }

    // Opvragen van alle variabelen binnen een entiteit.
    public function getFields() : array {
        return [['name']];
    }

    // Opvragen van variable van een entiteit die bewerkt mogen worden.
    public function getUpdateableFields() : array {
        return [['name']];
    }

    // Functie voor het aanmaken van een model class
    public function createModel() : \app\framework\model\Model {
        return new \app\entity\model\Category();
    }

    // Aanmaken van een database query class voor de model class 
    public function createDatabase() : \app\framework\database\CRUD {
        return new \app\entity\database\Category();
    }

    // Databinding van gegevens aan de model class
    public function bindModel(\app\framework\model\Model $model, Array $value) : \app\framework\model\Model {
        switch($value[0]){
            case 'name':
                $model->setName(end($value));
                break;
          }
        return $model;
    }
}
$api = new \app\entity\api\Category();
?>