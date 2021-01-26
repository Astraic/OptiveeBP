<?php
namespace app\framework\database;
interface Delete {
    function delete(\app\framework\model\Model $model) : String;
}
