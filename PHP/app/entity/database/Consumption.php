<?php
namespace app\entity\database;

require_once(dirname(__FILE__,3) . '/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,3) . '/framework/database/Database.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUD.php');
require_once(dirname(__FILE__,3) . '/framework/database/Read.php');
require_once(dirname(__FILE__,3) . '/framework/database/Write.php');
require_once(dirname(__FILE__,3) . '/framework/database/Update.php');
require_once(dirname(__FILE__,3) . '/entity/model/Consumption.php');

/**
 * Databinding voor create, update en read queries voor Consumption model class.
 * @author Stephan de Jongh
 */

class Consumption extends \app\framework\database\CRUD implements \app\framework\database\Read, \app\framework\database\Write, \app\framework\database\Update {

    // Constructor ter voorbereiding prepared insert statement.
    function __construct(\app\framework\database\QueryBuilderParent ...$query){
        $sql = "INSERT INTO Consumption (animalid, date, time, feedid, portion, assigned, consumption) VALUES (:animalid, :date, :time, :feedid, :portion, :assigned, :consumption)";
        $this->insert = \app\framework\database\Database::getConnection()->prepare($sql);
        parent::__construct($query);
    }

    // Functie om model variable aan prepared insert statement toe te voegen
    // en vervolgens het prepared statement uit te voeren, return error code voor succesindicatie.
    function insert(\app\framework\model\Model $model) : String{
        try{
            $this->insert->bindValue(':animalid', $model->getAnimalid());
        }catch(\app\framework\exception\ModelNullException $e){
            $this->insert->bindValue(':animalid', null);
        }
        try{
            $this->insert->bindValue(':date', $model->getDate());
        }catch(\app\framework\exception\ModelNullException $e){
            $this->insert->bindValue(':date', null);
        }
        try{
            $this->insert->bindValue(':time', $model->getTime());
        }catch(\app\framework\exception\ModelNullException $e){
            $this->insert->bindValue(':time', null);
        }
        try{
            $this->insert->bindValue(':feedid', $model->getFeedid());
        }catch(\app\framework\exception\ModelNullException $e){
            $this->insert->bindValue(':feedid', null);
        }
        try{
            $this->insert->bindValue(':portion', $model->getPortion());
        }catch(\app\framework\exception\ModelNullException $e){
            $this->insert->bindValue(':portion', null);
        }
        try{
            $this->insert->bindValue(':assigned', $model->getAssigned());
        }catch(\app\framework\exception\ModelNullException $e){
            $this->insert->bindValue(':assigned', null);
        }
        try{
            $this->insert->bindValue(':consumption', $model->getConsumption());
        }catch(\app\framework\exception\ModelNullException $e){
            $this->insert->bindValue(':consumption', null);
        }

        $this->insert->execute();
        return $this->insert->errorCode();
    }

    // Functie voor het selecteren van gegevens op basis model variabelen
    // return een array met model classes terug met overeenkomstige resultaten.
    function select(\app\framework\model\Model $model) : array{
        try{
            $this->select[0]->bindValue(':animalid', $model->getAnimalid());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':date', $model->getDate());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':time', $model->getTime());
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
        try{
            $this->select[0]->bindValue(':consumption', $model->getConsumption());
        }catch(\app\framework\exception\ModelNullException $e){}

        $this->select[0]->execute();
        $results = $this->select[0]->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, '\app\entity\model\Consumption');
        return array($this->select[0]->errorCode(), array($results));
    }

    // Functie voor het updaten van gegevens op basis van nieuw model
    // uitvoering van prepared statement, return error code voor succesindicatie.
    function update(\app\framework\model\Model $model, \app\framework\model\Model $modelOld) : String {
        try{
            $this->update[0]->bindValue(':feedidUpdate', $model->getFeedid());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':portionUpdate', $model->getPortion());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':assignedUpdate', $model->getAssigned());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':consumptionUpdate', $model->getConsumption());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':animalid', $modelOld->getAnimalid());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':date', $modelOld->getDate());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':time', $modelOld->getTime());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':feedid', $modelOld->getFeedid());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':portion', $modelOld->getPortion());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':assigned', $modelOld->getAssigned());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':consumption', $modelOld->getConsumption());
        }catch(\app\framework\exception\ModelNullException $e){}

        $this->update[0]->execute();
        return $this->update[0]->errorCode();
    }
}
?>