<?php
namespace app\entity\database;

require_once(dirname(__FILE__,3) . '/framework/database/Database.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUD.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUInterface.php');
require_once(dirname(__FILE__,3) . '/entity/model/FeedDistribution.php');

/**
 * Databinding voor create, update en read queries voor feeddistribution model class.
 * @author Stephan de Jongh
 */

class FeedDistribution extends \framework\database\CRUD implements \framework\database\CRUInterface {

    // Constructor ter voorbereiding prepared insert statement.
    function __construct(QueryBuilderParent ...$query){
        $sql = "INSERT INTO FeedDistribution (animelid, date, time, feedname, portionsize, allocated, consumed) VALUES (:animelid, :date, :time, :feedname, :portionsize, :allocated, :consumed)";
        $this->insert = \database\Database::getConnection()->prepare($sql);
        parent::__construct($query);
    }

    // Functie om model variable aan prepared insert statement toe te voegen
    // en vervolgens het prepared statement uit te voeren, return error code voor succesindicatie.
    function insert(\model\Model $model) : String{
        try{
            $this->insert->bindValue(':animalid', $model->getAnimalid());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':animalid', null);
        }
        try{
            $this->insert->bindValue(':date', $model->getDate());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':date', null);
        }
        try{
            $this->insert->bindValue(':time', $model->getTime());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':time', null);
        }
        try{
            $this->insert->bindValue(':feedname', $model->getFeedname());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':feedname', null);
        }
        try{
            $this->insert->bindValue(':portionsize', $model->getPortionsize());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':portionsize', null);
        }
        try{
            $this->insert->bindValue(':allocated', $model->getAllocated());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':allocated', null);
        }
        try{
            $this->insert->bindValue(':consumed', $model->getConsumed());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':consumed', null);
        }

        $this->insert->execute();
        return $this->insert->errorCode();
    }

    // Functie voor het selecteren van gegevens op basis model variabelen
    // return een array met model classes terug met overeenkomstige resultaten.
    function select(\model\Model $model) : array{
        try{
            $this->select[0]->bindValue(':animalid', $model->getAnimalid());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':date', $model->getDate());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':time', $model->getTime());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':feedname', $model->getFeedname());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':portionsize', $model->getPortionsize());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':allocated', $model->getAllocated());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':consumed', $model->getConsumed());
        }catch(\exception\ModelNullException $e){}

        $this->select[0]->execute();
        $results = $this->select[0]->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'model\FeedDistribution');
        return array($this->select[0]->errorCode(), array($results));
    }

    // Functie voor het updaten van gegevens op basis van nieuw model
    // uitvoering van prepared statement, return error code voor succesindicatie.
    function update(\model\Model $model, \model\Model $modelOld) : String {
        try{
            $this->update[0]->bindValue(':animalidUpdate', $model->getAnimalid());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':dateUpdate', $model->getDate());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':timeUpdate', $model->getTime());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':feednameUpdate', $model->getFeedname());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':portionsizeUpdate', $model->getPortionsize());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':allocatedUpdate', $model->getAllocated());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':consumedUpdate', $model->getConsumed());
        }catch(\exception\ModelNullException $e){}

        try{
            $this->update[0]->bindValue(':animalid', $modelOld->getAnimalid());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':date', $modelOld->getDate());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':time', $modelOld->getTime());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':feedname', $modelOld->getFeedname());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':portionsize', $modelOld->getPortionsize());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':allocated', $modelOld->getAllocated());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':consumed', $modelOld->getConsumed());
        }catch(\exception\ModelNullException $e){}

        $this->update[0]->execute();
        return $this->update[0]->errorCode();
    }
}
?>