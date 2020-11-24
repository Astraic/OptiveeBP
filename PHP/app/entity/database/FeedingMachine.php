<?php
namespace app\entity\database;

require_once(dirname(__FILE__,3) . '/framework/database/Database.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUD.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUInterface.php');
require_once(dirname(__FILE__,3) . '/entity/model/FeedingMachine.php');

/**
 * Databinding voor create, update en read queries voor feedingmachine model class.
 * @author Stephan de Jongh
 */

class FeedingMachine extends \framework\database\CRUD implements \framework\database\CRUInterface {

    // Constructor ter voorbereiding prepared insert statement.
    function __construct(QueryBuilderParent ...$query){
        $sql = "INSERT INTO FeedingMachine (hardwareid, group, feedname, allocated, portionsize) VALUES (:hardwareid, :group, :feedname, :allocated, :portionsize)";
        $this->insert = \database\Database::getConnection()->prepare($sql);
        parent::__construct($query);
    }

    // Functie om model variable aan prepared insert statement toe te voegen
    // en vervolgens het prepared statement uit te voeren, return error code voor succesindicatie.
    function insert(\model\Model $model) : String{
        try{
            $this->insert->bindValue(':hardwareid', $model->getHardwareid());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':hardwareid', null);
        }
        try{
            $this->insert->bindValue(':group', $model->getGroup());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':group', null);
        }
        try{
            $this->insert->bindValue(':feedname', $model->getFeedname());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':feedname', null);
        }
        try{
            $this->insert->bindValue(':allocated', $model->getAllocated());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':allocated', null);
        }
        try{
            $this->insert->bindValue(':portionsize', $model->getPortionsize());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':portionsize', null);
        }

        $this->insert->execute();
        return $this->insert->errorCode();
    }

    // Functie voor het selecteren van gegevens op basis model variabelen
    // return een array met model classes terug met overeenkomstige resultaten.
    function select(\model\Model $model) : array{
        try{
            $this->select[0]->bindValue(':hardwareid', $model->getHardwareid());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':group', $model->getGroup());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':feedname', $model->getFeedname());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':allocated', $model->getAllocated());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':portionsize', $model->getPortionsize());
        }catch(\exception\ModelNullException $e){}

        $this->select[0]->execute();
        $results = $this->select[0]->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'model\FeedingMachine');
        return array($this->select[0]->errorCode(), array($results));
    }

    // Functie voor het updaten van gegevens op basis van nieuw model
    // uitvoering van prepared statement, return error code voor succesindicatie.
    function update(\model\Model $model, \model\Model $modelOld) : String {
        try{
            $this->update[0]->bindValue(':hardwareidUpdate', $model->getHardwareid());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':groupUpdate', $model->getGroup());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':feednameUpdate', $model->getFeedname());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':allocatedUpdate', $model->getAllocated());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':portionsizeUpdate', $model->getPortionsize());
        }catch(\exception\ModelNullException $e){}

        try{
            $this->update[0]->bindValue(':hardwareid', $modelOld->getHardwareid());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':group', $modelOld->getGroup());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':feedname', $modelOld->getFeedname());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':allocated', $modelOld->getAllocated());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':portionsize', $modelOld->getPortionsize());
        }catch(\exception\ModelNullException $e){}

        $this->update[0]->execute();
        return $this->update[0]->errorCode();
    }
}
?>