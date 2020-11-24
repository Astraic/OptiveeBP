<?php
namespace app\framework\database;
require_once(dirname(__FILE__,1) . '/CRUInterface.php');
interface CRUDInterface extends CRUInterface{
    function delete(\app\framework\model\Model $model) : String;
}
