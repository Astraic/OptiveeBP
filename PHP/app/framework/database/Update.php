<?php
namespace app\framework\database;
interface Update {
    function update(\app\framework\model\Model $model, \app\framework\model\Model $modelOld) : String;
}
