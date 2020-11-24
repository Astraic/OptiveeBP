<?php
namespace app\entity\api;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/api/ForcedApi.php');
require_once(dirname(__FILE__,3) . '/entity/model/Classification.php');
require_once(dirname(__FILE__,3) . '/entity/database/Classification.php');

/**
 * API ter behoeve van framework voor classification model class.
 * @author Stephan de Jongh
 */

class Classification extends \app\framework\api\ForcedApi {
    public function __construct(){
        parent::__construct();
    }

    // Opvragen van alle variabelen binnen een entiteit.
    public static function getFields() {
        return [['animalid'], ['date'], ['time'], ['category'], ['fatgrade'], ['meatgrade'], ['amount']];
    }

    // Opvragen van variable van een entiteit die bewerkt mogen worden.
    public static function getUpdateableFields() {
        return [['category'], ['fatgrade'], ['meatgrade'], ['amount']];
    }

    // Functie voor het aanmaken van een model class
    public function createModel() : \app\framework\model\Model {
        return new \app\entity\model\Classification();
    }

    // Aanmaken van een database query class voor de model class 
    public function createDatabase() : \app\framework\database\CRUD {
        return new \app\entity\database\Classification();
    }

    // Databinding van gegevens aan de model class
    public function bindModel(\app\framework\model\Model $model, Array $value) : \app\framework\model\Model {
          switch($value[0]){
            case 'animalid':
                $model->setAnimalid(end($value));
                break;
            case 'date':
                $model->setDate(end($value));
                break;
            case 'time':
                $model->setTime(end($value));
                break; 
            case 'category':
                $model->setCategory(end($value));
                break; 
            case 'fatgrade':
                $model->setFatgrade(end($value));
                break;
            case 'meatgrade':
                $model->setMeatgrade(end($value));
                break;     
            case 'amount':
                $model->setAmount(end($value));
                break;          
          }
        return $model;
    }
}
$api = new \app\entity\api\Classification();
?>