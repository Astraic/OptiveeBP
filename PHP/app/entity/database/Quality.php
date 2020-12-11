<?php
namespace app\entity\database;

require_once(dirname(__FILE__,3) . '/framework/database/Database.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUD.php');
require_once(dirname(__FILE__,3) . '/framework/database/Read.php');
require_once(dirname(__FILE__,3) . '/framework/database/Write.php');
require_once(dirname(__FILE__,3) . '/framework/database/Update.php');
require_once(dirname(__FILE__,3) . '/entity/model/Quality.php');

/**
 * Databinding voor create, update en read queries voor Quality model class.
 * @author Stephan de Jongh
 */

class Quality extends \framework\database\CRUD implements \framework\database\Read, \framework\database\Write, \framework\database\Update {

    // Constructor ter voorbereiding prepared insert statement.
    function __construct(QueryBuilderParent ...$query){
        $sql = "INSERT INTO Quality (animelid, date, time, catname, fatname, meatname, amount) VALUES (:animelid, :date, :time, :catname, :fatname, :meatname, :amount)";
        $this->insert = \database\Database::getConnection()->prepare($sql);
        parent::__construct($query);
    }

    // Functie om model variable aan prepared insert statement toe te voegen
    // en vervolgens het prepared statement uit te voeren, return error code voor succesindicatie.
    function insert(\model\Model $model) : String{
        try{
            $this->insert->bindValue(':animelid', $model->getAnimalid());
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
            $this->insert->bindValue(':catname', $model->getCatname());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':catname', null);
        }
        try{
            $this->insert->bindValue(':fatname', $model->getFatname());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':fatname', null);
        }
        try{
            $this->insert->bindValue(':meatname', $model->getMeatname());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':meatname', null);
        }
        try{
            $this->insert->bindValue(':amount', $model->getAmount());
        }catch(ModelNullException $e){
            $this->insert->bindValue(':amount', null);
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
            $this->select[0]->bindValue(':catname', $model->getCatname());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':fatname', $model->getFatname());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':meatname', $model->getMeatname());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':amount', $model->getAmount());
        }catch(\exception\ModelNullException $e){}

        $this->select[0]->execute();
        $results = $this->select[0]->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'model\Quality');
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
            $this->update[0]->bindValue(':catnameUpdate', $model->getCatname());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':fatnameUpdate', $model->getFatname());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':meatnameUpdate', $model->getMeatname());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':amountUpdate', $model->getAmount());
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
            $this->update[0]->bindValue(':catname', $modelOld->getCatname());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':fatname', $modelOld->getFatname());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':meatname', $modelOld->getMeatname());
        }catch(\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':amount', $modelOld->getAmount());
        }catch(\exception\ModelNullException $e){}

        $this->update[0]->execute();
        return $this->update[0]->errorCode();
    }
}
?>