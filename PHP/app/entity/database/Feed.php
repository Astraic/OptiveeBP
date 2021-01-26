<?php
namespace app\entity\database;

require_once(dirname(__FILE__,3) . '/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,3) . '/framework/database/Database.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUD.php');
require_once(dirname(__FILE__,3) . '/framework/database/Read.php');
require_once(dirname(__FILE__,3) . '/framework/database/Write.php');
require_once(dirname(__FILE__,3) . '/framework/database/Update.php');
require_once(dirname(__FILE__,3) . '/entity/model/Feed.php');

/**
 * Databinding voor create, update en read queries voor feed model class.
 * @author Stephan de Jongh
 */

class Feed extends \app\framework\database\CRUD implements \app\framework\database\Read, \app\framework\database\Write, \app\framework\database\Update {

    // Constructor ter voorbereiding prepared insert statement.
    function __construct(\app\framework\database\QueryBuilderParent ...$query){
        $sql = "INSERT INTO Feed (name) VALUES (:name)";
        $this->insert = \app\framework\database\Database::getConnection()->prepare($sql);
        parent::__construct($query);
    }

    // Functie om model variable aan prepared insert statement toe te voegen
    // en vervolgens het prepared statement uit te voeren, return error code voor succesindicatie.
    function insert(\app\framework\model\Model $model) : String{
        try{
            $this->insert->bindValue(':name', $model->getName());
        }catch(\app\framework\exception\ModelNullException $e){
            $this->insert->bindValue(':name', null);
        }

        $this->insert->execute();
        return $this->insert->errorCode();
    }

    // Functie voor het selecteren van gegevens op basis model variabelen
    // return een array met model classes terug met overeenkomstige resultaten.
    function select(\app\framework\model\Model $model) : array{
        try{
            $this->select[0]->bindValue(':id', $model->getId());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':name', $model->getName());
        }catch(\app\framework\exception\ModelNullException $e){}

        $this->select[0]->execute();
        $results = $this->select[0]->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, '\app\entity\model\Feed');
        return array($this->select[0]->errorCode(), array($results));
    }

    // Functie voor het updaten van gegevens op basis van nieuw model
    // uitvoering van prepared statement, return error code voor succesindicatie.
    function update(\app\framework\model\Model $model, \app\framework\model\Model $modelOld) : String {
        try{
            $this->update[0]->bindValue(':nameUpdate', $model->getName());
        }catch(\app\framework\exception\ModelNullException $e){}

        try{
            $this->update[0]->bindValue(':id', $modelOld->getId());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':name', $modelOld->getName());
        }catch(\app\framework\exception\ModelNullException $e){}

        $this->update[0]->execute();
        return $this->update[0]->errorCode();
    }
}
?>