<?php
namespace app\entity\database;
require_once(dirname(__FILE__,3) . '/framework/database/Database.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUD.php');
require_once(dirname(__FILE__,3) . '/framework/database/Read.php');
require_once(dirname(__FILE__,3) . '/framework/database/Write.php');
require_once(dirname(__FILE__,3) . '/framework/database/Update.php');
require_once(dirname(__FILE__,3) . '/entity/model/Production.php');

  class Production extends \framework\database\CRUD implements \app\framework\database\Read,
                                                              \app\framework\database\Write,
                                                              \app\framework\database\Update {

      function __construct(QueryBuilderParent ...$query){
            $sql = "INSERT INTO Production (animal, production, product, productiondate, productiontime) VALUES (:animal, :production, :product, :productiondate, :productiontime)";
            $this->insert = \database\Database::getConnection()->prepare($sql);
            parent::__construct($query);
      }

      function insert(\model\Model $model) : String{
          try{
              $this->insert->bindValue(':animal', $model->getAnimal());
          }catch(\app\framework\exception\ModelNullException $e){
              $this->insert->bindValue(':animal', null);
          }

          try{
              $this->insert->bindValue(':production', $model->getProduction());
          }catch(\app\framework\exception\ModelNullException $e){
              $this->insert->bindValue(':production', null);
          }
          try{
              $this->insert->bindValue(':product', $model->getProduct());
          }catch(\app\framework\exception\ModelNullException $e){
              $this->insert->bindValue(':product', null);
          }

          try{
              $this->insert->bindValue(':productiondatetime', $model->getProductiondatetime());
          }catch(\app\framework\exception\ModelNullException $e){
              $this->insert->bindValue(':productiondatetime', null);
          }

          $this->insert->execute();

          return $this->insert->errorCode();
      }

      function select(\model\Model $model) : array{
          try{
              $this->select[0]->bindValue(':animal', $model->getAnimal());
          }catch(\app\framework\exception\ModelNullException $e){}
          try{
              $this->select[0]->bindValue(':production', $model->getProduction());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->select[0]->bindValue(':product', $model->getProduct());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->select[0]->bindValue(':productiondatetime', $model->getProductiondatetime());
          }catch(\app\framework\exception\ModelNullException $e){}


          $this->select[0]->execute();

          $results = $this->select[0]->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'model\Production');

          return array($this->select[0]->errorCode(), array($results));
      }

      function update(\model\Model $model, \model\Model $modelOld) : String {
          try{
              $this->update[0]->bindValue(':animalUpdate', $model->getAnimal());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':productionUpdate', $model->getProduct());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':productUpdate', $model->getProduction());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':productiondatetimeUpdate', $model->getProductiondatetime());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':animal', $modelOld->getAnimal());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':production', $modelOld->getProduct());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':product', $modelOld->getProduction());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':productiondatetime', $modelOld->getProductiondatetime());
          }catch(\app\framework\exception\ModelNullException $e){}

          $this->update[0]->execute();

          return $this->update[0]->errorCode();
      }
  }
?>
