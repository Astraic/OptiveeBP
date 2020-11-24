<?php
namespace app\entity\api;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/api/ForcedApi.php');
require_once(dirname(__FILE__,3) . '/entity/model/FeedingMachine.php');
require_once(dirname(__FILE__,3) . '/entity/database/FeedingMachine.php');

/**
 * API ter behoeve van framework voor feedingmachine model class.
 * @author Stephan de Jongh
 */

class FeedingMachine extends \app\framework\api\ForcedApi {
    public function __construct(){
        parent::__construct();
    }

    // Opvragen van alle variabelen binnen een entiteit.
    public static function getFields() {
        return [['hardwareid'], ['group'], ['feedname'], ['allocated'], ['portionsize']];
    }

    // Opvragen van variable van een entiteit die bewerkt mogen worden.
    public static function getUpdateableFields() {
        return [['group'], ['feedname'], ['allocated'], ['portionsize']];
    }

    // Functie voor het aanmaken van een model class
    public function createModel() : \app\framework\model\Model {
        return new \app\entity\model\FeedingMachine();
    }

    // Aanmaken van een database query class voor de model class 
    public function createDatabase() : \app\framework\database\CRUD {
        return new \app\entity\database\FeedingMachine();
    }

    // Databinding van gegevens aan de model class
    public function bindModel(\app\framework\model\Model $model, Array $value) : \app\framework\model\Model {
          switch($value[0]){
            case 'hardwareid':
                $model->setHardwareid(end($value));
                break;
            case 'group':
                $model->setGroup(end($value));
                break;
            case 'feedname':
                $model->setFeedname(end($value));
                break; 
            case 'allocated':
                $model->setAllocated(end($value));
                break; 
            case 'portionsize':
                $model->setPortionsize(end($value));
                break;       
          }
        return $model;
    }
}
$api = new \app\entity\api\FeedingMachine();
?>