<?php
namespace app\entity\model;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,3) . '/framework/model/Model.php');

class Animal extends \app\framework\model\Model {

    protected $country;
    protected $serial;
    protected $working;
    protected $control;
    protected $product;
    protected $environment;
    protected $passdate;
    protected $reasonofdeath;
    protected $nfc;
    protected $id;

    //return the result of this object to the UI
    public function jsonSerialize() {
      $vars = get_object_vars($this);
      $json = parent::setUpJson($vars);
      return $json;
    }

    public function setCountry($country){
        $this->country = $country;
    }

    public function getCountry() {
        if($this->country !== null) {
            return $this->country;
        }
        throw new \app\framework\exception\ModelNullException("country is not set");
    }

    public function setSerial($serial){
        $this->serial = $serial;
    }

    public function getSerial() {
        if($this->serial !== null) {
            return $this->serial;
        }
        throw new \app\framework\exception\ModelNullException("serial is not set");
    }

    public function setWorking($working){
        $this->working = $working;
    }

    public function getWorking() {
        if($this->working !== null) {
            return $this->working;
        }
        throw new \app\framework\exception\ModelNullException("working is not set");
    }

    public function setControl($control){
        $this->control = $control;
    }

    public function getControl() {
        if($this->control !== null) {
            return $this->control;
        }
        throw new \app\framework\exception\ModelNullException("control is not set");
    }




    public function setProduct($product){
        $this->product = $product;
    }

    public function getProduct() {
        if($this->product !== null) {
            return $this->product;
        }
        throw new \app\framework\exception\ModelNullException("product is not set");
    }

    public function setEnvironment($environment){
        $this->environment = $environment;
    }

    public function getEnvironment() {
        if($this->environment !== null) {
            return $this->environment;
        }
        throw new \app\framework\exception\ModelNullException("environment is not set");
    }



    public function getPassdate() {
        if($this->passdate !== null) {
           return $this->passdate;
        }
        throw new \app\framework\exception\ModelNullException("passdate is not set");
    }

    public function setPassdate($passdate){
        $this->passdate = $passdate;
    }
    public function getReasonofdeath() {
        if($this->reasonofdeath !== null) {
           return $this->reasonofdeath;
        }
        throw new \app\framework\exception\ModelNullException("reasonofdeath is not set");
    }

    public function setReasonofdeath($reasonofdeath){
        $this->reasonofdeath = $reasonofdeath;
    }

    public function getNfc() {
        if($this->nfc !== null) {
           return $this->nfc;
        }
        throw new \app\framework\exception\ModelNullException("nfc is not set");
    }

    public function setNfc($nfc){
        $this->nfc = $nfc;
    }

    public function getId() {
        if($this->id !== null) {
           return $this->id;
        }
        throw new \app\framework\exception\ModelNullException("id is not set");
    }

    public function setId($id){
        $this->id = $id;
    }
}
