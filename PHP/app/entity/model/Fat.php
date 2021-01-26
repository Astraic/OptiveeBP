<?php
namespace app\entity\model;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,3) . '/framework/model/Model.php');

/**
 * Fat model class op basis van \app\framework\model\Model
 * @author Stephan de Jongh
 */

class Fat extends \app\framework\model\Model {
    protected $name;

    // functie voor het maken van een json als php object met de objectvariabelen
    // deze functie is voor elke model class exact hetzelfde, behoort dit niet in de superclass \app\framework\model\Model?
    public function jsonSerialize() {
        $vars = get_object_vars($this);
        $json = parent::setUpJson($vars);
        return $json;
    }

    // getters en setters voor de variabelen
    // roept app\framework\exception\ModelNullException indien variable null is
    public function setName($name){
        $this->name = $name;
    }

    public function getName() {
        if($this->name !== null) {
            return $this->name;
        }
        throw new \app\framework\exception\ModelNullException("Name variable is not set correctly.");
    }
}
?>