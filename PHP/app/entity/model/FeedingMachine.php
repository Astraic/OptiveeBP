<?php
namespace app\entity\model;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,3) . '/framework/model/Model.php');

/**
 * FeedingMachine model class op basis van \app\framework\model\Model
 * @author Stephan de Jongh
 */

class FeedingMachine extends \app\framework\model\Model {
    protected $hardwareid;
    protected $group;
    protected $feedname;
    protected $allocated;
    protected $portionsize;

    // functie voor het maken van een json als php object met de objectvariabelen
    // deze functie is voor elke model class exact hetzelfde, behoort dit niet in de superclass \app\framework\model\Model?
    public function jsonSerialize() {
        $vars = get_object_vars($this);
        $json = parent::setUpJson($vars);
        return $json;
    }

    // getters en setters voor de variabelen
    // roept app\framework\exception\ModelNullException indien variable null is
    public function setHardwareid($hardwareid){
        $this->hardwareid = $hardwareid;
    }

    public function getHardwareid() {
        if($this->hardwareid !== null) {
            return $this->hardwareid;
        }
        throw new \app\framework\exception\ModelNullException("Hardwareid variable is not set correctly.");
    }

    public function setGroup($group){
        $this->group = $group;
    }

    public function getGroup() {
        if($this->group !== null) {
            return $this->group;
        }
        throw new \app\framework\exception\ModelNullException("Group variable is not set correctly.");
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
    
    public function setAllocated($allocated){
        $this->allocated = $allocated;
    }

    public function getAllocated() {
        if($this->allocated !== null) {
            return $this->allocated;
        }
        throw new \app\framework\exception\ModelNullException("Allocated variable is not set correctly.");
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
}
?>