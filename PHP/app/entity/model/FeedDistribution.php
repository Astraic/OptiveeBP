<?php
namespace app\entity\model;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,3) . '/framework/model/Model.php');

/**
 * FeedDistribution model class op basis van \app\framework\model\Model
 * @author Stephan de Jongh
 */

class FeedDistribution extends \app\framework\model\Model {
    protected $animalid;
    protected $date;
    protected $time;
    protected $feedname;
    protected $portionsize;
    protected $allocated;
    protected $consumed;

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

    public function setFeedname($feedname){
        $this->feedname = $feedname;
    }

    public function getFeedname() {
        if($this->feedname !== null) {
            return $this->feedname;
        }
        throw new \app\framework\exception\ModelNullException("Feedname variable is not set correctly.");
    }

    public function setPortionsize($portionsize){
        $this->portionsize = $portionsize;
    }

    public function getPortionsize() {
        if($this->portionsize !== null) {
            return $this->portionsize;
        }
        throw new \app\framework\exception\ModelNullException("Portionsize variable is not set correctly.");
    }

    public function setAllocated($allocated){
        $this->allocated = $allocated;
    }

    public function getAllocated() {
        if($this->allocated !== null) {
            return $this->allocated;
        }
        throw new \app\framework\exception\ModelNullException("Allocated variable is not set correctly.");
    }

    public function setConsumed($consumed){
        $this->consumed = $consumed;
    }

    public function getConsumed() {
        if($this->consumed !== null) {
            return $this->consumed;
        }
        throw new \app\framework\exception\ModelNullException("Consumed variable is not set correctly.");
    }
}
?>