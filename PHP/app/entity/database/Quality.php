<?php
namespace app\entity\database;

require_once(dirname(__FILE__,3) . '/framework/exception/ModelNullException.php');
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

class Quality extends \app\framework\database\CRUD implements \app\framework\database\Read, \app\framework\database\Write, \app\framework\database\Update {

    // Constructor ter voorbereiding prepared insert statement.
    function __construct(\app\framework\database\QueryBuilderParent ...$query){
        $sql = "INSERT INTO Quality (animelid, date, time, catname, fatname, meatname, amount) VALUES (:animelid, :date, :time, :catname, :fatname, :meatname, :amount)";
        $this->insert = \app\framework\database\Database::getConnection()->prepare($sql);
        parent::__construct($query);
    }

    // Functie om model variable aan prepared insert statement toe te voegen
    // en vervolgens het prepared statement uit te voeren, return error code voor succesindicatie.
    function insert(\app\framework\model\Model $model) : String{
        try{
            $this->insert->bindValue(':animelid', $model->getAnimalid());
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
            $this->insert->bindValue(':catname', $model->getCatname());
        }catch(\app\framework\exception\ModelNullException $e){
            $this->insert->bindValue(':catname', null);
        }
        try{
            $this->insert->bindValue(':fatname', $model->getFatname());
        }catch(\app\framework\exception\ModelNullException $e){
            $this->insert->bindValue(':fatname', null);
        }
        try{
            $this->insert->bindValue(':meatname', $model->getMeatname());
        }catch(\app\framework\exception\ModelNullException $e){
            $this->insert->bindValue(':meatname', null);
        }
        try{
            $this->insert->bindValue(':amount', $model->getAmount());
        }catch(\app\framework\exception\ModelNullException $e){
            $this->insert->bindValue(':amount', null);
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
            $this->select[0]->bindValue(':catname', $model->getCatname());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':fatname', $model->getFatname());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':meatname', $model->getMeatname());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->select[0]->bindValue(':amount', $model->getAmount());
        }catch(\app\framework\exception\ModelNullException $e){}

        $this->select[0]->execute();
        $results = $this->select[0]->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, '\app\entity\model\Quality');
        return array($this->select[0]->errorCode(), array($results));
    }

    // Functie voor het updaten van gegevens op basis van nieuw model
    // uitvoering van prepared statement, return error code voor succesindicatie.
    function update(\app\framework\model\Model $model, \app\framework\model\Model $modelOld) : String {
        try{
            $this->update[0]->bindValue(':catnameUpdate', $model->getCatname());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':fatnameUpdate', $model->getFatname());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':meatnameUpdate', $model->getMeatname());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':amountUpdate', $model->getAmount());
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
            $this->update[0]->bindValue(':catname', $modelOld->getCatname());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':fatname', $modelOld->getFatname());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':meatname', $modelOld->getMeatname());
        }catch(\app\framework\exception\ModelNullException $e){}
        try{
            $this->update[0]->bindValue(':amount', $modelOld->getAmount());
        }catch(\app\framework\exception\ModelNullException $e){}

        $this->update[0]->execute();
        return $this->update[0]->errorCode();
    }
}
?>