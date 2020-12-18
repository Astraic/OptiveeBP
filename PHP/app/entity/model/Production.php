<?php
namespace app\entity\model;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,3) . '/framework/model/Model.php');

class Production extends \app\framework\model\Model {

    protected $product;
    protected $production;
    protected $animal;
    protected $productiondatetime;
    
    //return the result of this object to the UI
    public function jsonSerialize() {
      $vars = get_object_vars($this);
      $json = parent::setUpJson($vars);
      return $json;
    }

    public function getProduct() {
        if($this->product !== null) {
           return $this->product;
        }
        throw new \app\framework\exception\ModelNullException("product is not set");
    }

    public function setProduct($product){
        $this->product = $product;
    }
             public function getProduction() {
        if($this->production !== null) {
           return $this->production;
        }
        throw new \app\framework\exception\ModelNullException("production is not set");
    }

    public function setProduction($production){
        $this->production = $production;
    }
             public function getAnimal() {
        if($this->animal !== null) {
           return $this->animal;
        }
        throw new \app\framework\exception\ModelNullException("animal is not set");
    }

    public function setAnimal($animal){
        $this->animal = $animal;
    }
             public function getProductiondatetime() {
        if($this->productiondatetime !== null) {
           return $this->productiondatetime;
        }
        throw new \app\framework\exception\ModelNullException("productiondatetime is not set");
    }

    public function setProductiondatetime($productiondatetime){
        $this->productiondatetime = $productiondatetime;
    }
}
