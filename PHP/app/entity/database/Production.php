<?php
namespace app\entity\database;
require_once(dirname(__FILE__,3) . '/framework/database/Database.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUD.php');
require_once(dirname(__FILE__,3) . '/framework/database/Read.php');
require_once(dirname(__FILE__,3) . '/framework/database/Write.php');
require_once(dirname(__FILE__,3) . '/framework/database/Update.php');
require_once(dirname(__FILE__,3) . '/entity/model/Production.php');

  class Production extends \app\framework\database\CRUD implements \app\framework\database\Read,
                                                              \app\framework\database\Write,
                                                              \app\framework\database\Update {

      function __construct(QueryBuilderParent ...$query){
            $sql = "INSERT INTO Production (animal, production, product, productiondatetime) VALUES (:animal, :production, :product, :productiondatetime)";
            $this->insert = \app\framework\database\Database::getConnection()->prepare($sql);
            parent::__construct($query);
      }

      function insert(\app\framework\model\Model $model) : String{

          var_dump($model);
          var_dump($this->insert);
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
              $this->insert->bindValue(':productiondatetime', $model->getProductiondatetime()->format('Y-m-d H:i:s'));
          }catch(\app\framework\exception\ModelNullException $e){
              $this->insert->bindValue(':productiondatetime', null);
          }

          $this->insert->execute();
          var_dump($this->insert->errorInfo());
          return $this->insert->errorCode();
      }

      function select(\app\framework\model\Model $model) : array{
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
              $this->select[0]->bindValue(':productiondatetime', $model->getProductiondatetime()->format('Y-m-d H:i:s'));
          }catch(\app\framework\exception\ModelNullException $e){}


          $this->select[0]->execute();

          $results = $this->select[0]->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, '\app\entity\model\Production');

          return array($this->select[0]->errorCode(), array($results));
      }

      function update(\app\framework\model\Model $model, \app\framework\model\Model $modelOld) : String {
          try{
              $this->update[0]->bindValue(':animalUpdate', $model->getAnimal());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':productionUpdate', $model->getProduction());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':productUpdate', $model->getProduct());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':productiondatetimeUpdate', $model->getProductiondatetime()->format('Y-m-d H:i:s'));
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':animal', $modelOld->getAnimal());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':production', $modelOld->getProduction());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':product', $modelOld->getProduct());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':productiondatetime', $modelOld->getProductiondatetime()->format('Y-m-d H:i:s'));
          }catch(\app\framework\exception\ModelNullException $e){}

          $this->update[0]->execute();

          return $this->update[0]->errorCode();
      }
  }
?>
