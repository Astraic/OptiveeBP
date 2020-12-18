<?php
namespace app\entity\model;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,3) . '/framework/model/Model.php');

class Reasonofdeath extends \app\framework\model\Model {

    protected $reasonofdeath;
    //return the result of this object to the UI
    public function jsonSerialize() {
      $vars = get_object_vars($this);
      $json = parent::setUpJson($vars);
      return $json;
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
}
