<?php
namespace app\framework\database;
interface Read {
    function select(\app\framework\model\Model $model) : array;
}
