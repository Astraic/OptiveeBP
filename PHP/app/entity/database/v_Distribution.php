<?php
namespace app\entity\database;

require_once(dirname(__FILE__,3) . '/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,3) . '/framework/database/Database.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUD.php');
require_once(dirname(__FILE__,3) . '/framework/database/Read.php');
require_once(dirname(__FILE__,3) . '/entity/model/v_Distribution.php');

/**
 * Databinding voor create, update en read queries voor v_Distribution model class.
 * @author Stephan de Jongh
 */

class v_Distribution extends \app\framework\database\CRUD implements \app\framework\database\Read {

    // Constructor ter voorbereiding prepared insert statement.
    function __construct(\app\framework\database\QueryBuilderParent ...$query){
        parent::__construct($query);
    }

    // Functie voor het selecteren van gegevens op basis model variabelen
    // return een array met model classes terug met overeenkomstige resultaten.
    function select(\app\framework\model\Model $model) : array{
        try{
            $this->select[0]->bindValue(':nfc', $model->getNfc());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':feedid', $model->getFeedid());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':portion', $model->getPortion());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':assigned', $model->getAssigned());
        }catch(\app\framework\exception\ModelNullException $e){}

        $this->select[0]->execute();
        $results = $this->select[0]->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, '\app\entity\model\v_Distribution');
        return array($this->select[0]->errorCode(), array($results));
    }
}
?>