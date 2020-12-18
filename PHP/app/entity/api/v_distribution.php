<?php
namespace app\entity\api;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/api/ReadonlyApi.php');
require_once(dirname(__FILE__,3) . '/entity/model/v_Distribution.php');
require_once(dirname(__FILE__,3) . '/entity/database/v_Distribution.php');

/**
 * API ter behoeve van framework voor v_Distribution model class.
 * @author Stephan de Jongh
 */

class v_Distribution extends \app\framework\api\ReadonlyApi {
    public function __construct(){
        parent::__construct();
    }

    // Opvragen van alle variabelen binnen een entiteit.
    public static function getFields() {
        return [['nfc'], ['feedid'], ['portion'], ['assigned']];
    }

    // Opvragen van variable van een entiteit die bewerkt mogen worden.
    public static function getUpdateableFields() {
        return [];
    }

    // Functie voor het aanmaken van een model class
    public function createModel() : \app\framework\model\Model {
        return new \app\entity\model\v_Distribution();
    }

    // Aanmaken van een database query class voor de model class 
    public function createDatabase() : \app\framework\database\CRUD {
        return new \app\entity\database\v_Distribution();
    }

    // Databinding van gegevens aan de model class
    public function bindModel(\app\framework\model\Model $model, Array $value) : \app\framework\model\Model {
          switch($value[0]){
            case 'nfc':
                $model->setNfc(end($value));
                break;
            case 'feedid':
                $model->setFeedid(end($value));
                break; 
            case 'portion':
                $model->setPortion(end($value));
                break;
            case 'assigned':
                $model->setAssigned(end($value));
                break;             
          }
        return $model;
    }
}
$api = new \app\entity\api\v_Distribution();
?>