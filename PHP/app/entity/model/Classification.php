<?php
namespace app\entity\model;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,3) . '/framework/model/Model.php');

/**
 * Classification model class op basis van \app\framework\model\Model
 * @author Stephan de Jongh
 */

class Classification extends \app\framework\model\Model {
    protected $animalid;
    protected $date;
    protected $time;
    protected $category;
    protected $fatgrade;
    protected $meatgrade;
    protected $amount;

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

    public function setDate($date){
        $this->date = $date;
    }

    public function getDate() {
        if($this->date !== null) {
            return $this->date;
        }
        throw new \app\framework\exception\ModelNullException("Date variable is not set correctly.");
    }

    public function setTime($time){
        $this->time = $time;
    }

    public function getTime() {
        if($this->time !== null) {
            return $this->time;
        }
        throw new \app\framework\exception\ModelNullException("Time variable is not set correctly.");
    }

    public function setCategory($category){
        $this->category = $category;
    }

    public function getCategory() {
        if($this->category !== null) {
            return $this->category;
        }
        throw new \app\framework\exception\ModelNullException("Category variable is not set correctly.");
    }

    public function setFatgrade($fatgrade){
        $this->fatgrade = $fatgrade;
    }

    public function getFatgrade() {
        if($this->fatgrade !== null) {
            return $this->fatgrade;
        }
        throw new \app\framework\exception\ModelNullException("Fatgrade variable is not set correctly.");
    }
    
    public function setMeatgrade($meatgrade){
        $this->meatgrade = $meatgrade;
    }

    public function getMeatgrade() {
        if($this->meatgrade !== null) {
            return $this->meatgrade;
        }
        throw new \app\framework\exception\ModelNullException("Meatgrade variable is not set correctly.");
    }

    public function setAmount($amount){
        $this->amount = $amount;
    }

    public function getAmount() {
        if($this->amount !== null) {
            return $this->amount;
        }
        throw new \app\framework\exception\ModelNullException("Amount variable is not set correctly.");
    }
}
?>