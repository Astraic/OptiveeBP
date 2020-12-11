<?php
namespace app\entity\model;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,3) . '/framework/model/Model.php');

/**
 * Distribution model class op basis van \app\framework\model\Model
 * @author Stephan de Jongh
 */

class Distribution extends \app\framework\model\Model {
    protected $animalid;
    protected $feedid;
    protected $portion;
    protected $assigned;

    // functie voor het maken van een json als php object met de objectvariabelen
    // deze functie is voor elke model class exact hetzelfde, behoort dit niet in de superclass \app\framework\model\Model?
    public function jsonSerialize() {
        $vars = get_object_vars($this);
        $json = parent::setUpJson($vars);
        return $json;
    }

    // getters en setters voor de variabelen
    // roept app\framework\exception\ModelNullException indien variable null is
    public function setAnimalid($animalid){
        $this->animalid = $animalid;
    }

    public function getAnimalid() {
        if($this->animalid !== null) {
            return $this->animalid;
        }
        throw new \app\framework\exception\ModelNullException("Animalid variable is not set correctly.");
    }

    public function setFeedid($feedid){
        $this->feedid = $feedid;
    }

    public function getFeedid() {
        if($this->feedid !== null) {
            return $this->feedid;
        }
        throw new \app\framework\exception\ModelNullException("Feedid variable is not set correctly.");
    }

    public function setPortion($portion){
        $this->portion = $portion;
    }

    public function getPortion() {
        if($this->portion !== null) {
            return $this->portion;
        }
        throw new \app\framework\exception\ModelNullException("Portion variable is not set correctly.");
    }

    public function setAssigned($assigned){
        $this->assigned = $assigned;
    }

    public function getAssigned() {
        if($this->assigned !== null) {
            return $this->assigned;
        }
        throw new \app\framework\exception\ModelNullException("Assigned variable is not set correctly.");
    }
}
?>