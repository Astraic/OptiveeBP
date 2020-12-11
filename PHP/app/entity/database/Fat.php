<?php
namespace app\entity\database;

require_once(dirname(__FILE__,3) . '/framework/database/Database.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUD.php');
require_once(dirname(__FILE__,3) . '/framework/database/Read.php');
require_once(dirname(__FILE__,3) . '/framework/database/Write.php');
require_once(dirname(__FILE__,3) . '/framework/database/Update.php');
require_once(dirname(__FILE__,3) . '/entity/model/Fat.php');

/**
 * Databinding voor create, update en read queries voor Fat model class.
 * @author Stephan de Jongh
 */

class Fat extends \framework\database\CRUD implements \framework\database\Read, \framework\database\Write, \framework\database\Update {

    // Constructor ter voorbereiding prepared insert statement.
    function __construct(QueryBuilderParent ...$query){
        $sql = "INSERT INTO Fat (name) VALUES (:name)";
        $this->insert = \database\Database::getConnection()->prepare($sql);
        parent::__construct($query);
    }

    // Functie om model variable aan prepared insert statement toe te voegen
    // en vervolgens het prepared statement uit te voeren, return error code voor succesindicatie.
    function insert(\model\Model $model) : String{
        try{
            $this->insert->bindValue(':name', $model->getName());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':name', null);
        }

        $this->insert->execute();
        return $this->insert->errorCode();
    }

    // Functie voor het selecteren van gegevens op basis model variabelen
    // return een array met model classes terug met overeenkomstige resultaten.
    function select(\model\Model $model) : array{
        try{
            $this->select[0]->bindValue(':name', $model->getName());
        }catch(\exception\ModelNullException $e){}

        $this->select[0]->execute();
        $results = $this->select[0]->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'model\Fat');
        return array($this->select[0]->errorCode(), array($results));
    }

    // Functie voor het updaten van gegevens op basis van nieuw model
    // uitvoering van prepared statement, return error code voor succesindicatie.
    function update(\model\Model $model, \model\Model $modelOld) : String {
        try{
            $this->update[0]->bindValue(':nameUpdate', $model->getName());
        }catch(\exception\ModelNullException $e){}

        try{
            $this->update[0]->bindValue(':name', $modelOld->getName());
        }catch(\exception\ModelNullException $e){}

        $this->update[0]->execute();
        return $this->update[0]->errorCode();
    }
}
?>