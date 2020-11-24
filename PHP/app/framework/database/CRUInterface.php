<?php
namespace app\framework\database;
require_once(dirname(__FILE__,1) . '/CRInterface.php');
interface CRUInterface extends CRInterface{
    function update(\app\framework\model\Model $model, \app\framework\model\Model $modelOld) : String;
}
