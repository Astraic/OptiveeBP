<?php
namespace app\entity\database;

require_once(dirname(__FILE__,3) . '/framework/database/Database.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUD.php');
require_once(dirname(__FILE__,3) . '/framework/database/Read.php');
require_once(dirname(__FILE__,3) . '/framework/database/Write.php');
require_once(dirname(__FILE__,3) . '/framework/database/Update.php');
require_once(dirname(__FILE__,3) . '/entity/model/v_Distribution.php');

/**
 * Databinding voor create, update en read queries voor v_Distribution model class.
 * @author Stephan de Jongh
 */

class v_Distribution extends \framework\database\CRUD implements \framework\database\Read, \framework\database\Write, \framework\database\Update {

    // Constructor ter voorbereiding prepared insert statement.
    function __construct(QueryBuilderParent ...$query){
        $sql = "INSERT INTO v_Distribution (nfc, feedid, portion, assigned) VALUES (:nfc, :feedid, :portion, :assigned)";
        $this->insert = \database\Database::getConnection()->prepare($sql);
        parent::__construct($query);
    }

    // Functie om model variable aan prepared insert statement toe te voegen
    // en vervolgens het prepared statement uit te voeren, return error code voor succesindicatie.
    function insert(\model\Model $model) : String{
        try{
            $this->insert->bindValue(':nfc', $model->getNfc());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':nfc', null);
        }
        try{
            $this->insert->bindValue(':feedid', $model->getFeedid());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':feedid', null);
        }
        try{
            $this->insert->bindValue(':portion', $model->getPortion());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':portion', null);
        }
        try{
            $this->insert->bindValue(':assigned', $model->getAssigned());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':assigned', null);
        }

        $this->insert->execute();
        return $this->insert->errorCode();
    }

    // Functie voor het selecteren van gegevens op basis model variabelen
    // return een array met model classes terug met overeenkomstige resultaten.
    function select(\model\Model $model) : array{
        try{
            $this->select[0]->bindValue(':nfc', $model->getNfc());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':feedid', $model->getFeedid());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':portion', $model->getPortion());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':assigned', $model->getAssigned());
        }catch(\exception\ModelNullException $e){}

        $this->select[0]->execute();
        $results = $this->select[0]->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'model\v_Distribution');
        return array($this->select[0]->errorCode(), array($results));
    }

    // Functie voor het updaten van gegevens op basis van nieuw model
    // uitvoering van prepared statement, return error code voor succesindicatie.
    function update(\model\Model $model, \model\Model $modelOld) : String {
        try{
            $this->update[0]->bindValue(':nfcUpdate', $model->getNfc());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':feedidUpdate', $model->getFeedid());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':portionUpdate', $model->getPortion());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':assignedUpdate', $model->getAssigned());
        }catch(\exception\ModelNullException $e){}

        try{
            $this->update[0]->bindValue(':nfc', $modelOld->getNfc());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':feedid', $modelOld->getFeedid());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':portion', $modelOld->getPortion());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':assigned', $modelOld->getAssigned());
        }catch(\exception\ModelNullException $e){}

        $this->update[0]->execute();
        return $this->update[0]->errorCode();
    }
}
?>