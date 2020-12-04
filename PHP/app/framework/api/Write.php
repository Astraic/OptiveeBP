<?php
namespace app\framework\api;
require_once(dirname(__FILE__,1) . '/CRUInterface.php');
interface Write {
    function insert();
}
