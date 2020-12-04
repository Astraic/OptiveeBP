<?php
namespace app\framework\database;
interface Write {
    function insert(\app\framework\model\Model $model) : String;
}
