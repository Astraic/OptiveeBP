<?php
namespace app\framework\database;
interface CRInterface {
    function select(\app\framework\model\Model $model) : array;

    function insert(\app\framework\model\Model $model) : String;
}
