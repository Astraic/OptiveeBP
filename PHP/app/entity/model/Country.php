<?php
namespace app\entity\model;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__,3) . '/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,3) . '/framework/model/Model.php');

class Country extends \app\framework\model\Model {

    protected $code;
    protected $name;
    //return the result of this object to the UI
    public function jsonSerialize() {
      $vars = get_object_vars($this);
      $json = parent::setUpJson($vars);
      return $json;
    }



    public function getCode() {
        if($this->code !== null) {
           return $this->code;
        }
        throw new \app\framework\exception\ModelNullException("code is not set");
    }

    public function setCode($code){
        $this->code = $code;
    }

    public function getName() {
        if($this->name !== null) {
           return $this->name;
        }
        throw new \app\framework\exception\ModelNullException("name is not set");
    }

    public function setName($name){
        $this->name = $name;
    }
}
