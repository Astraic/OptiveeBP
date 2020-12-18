<?php
namespace app\entity\database;
require_once(dirname(__FILE__,3) . '/framework/database/Database.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUD.php');
require_once(dirname(__FILE__,3) . '/framework/database/Read.php');
require_once(dirname(__FILE__,3) . '/framework/database/Write.php');
require_once(dirname(__FILE__,3) . '/framework/database/Update.php');
require_once(dirname(__FILE__,3) . '/entity/model/Animal.php');

  class Animal extends \app\framework\database\CRUD implements \app\framework\database\Read,
                                                              \app\framework\database\Write,
                                                              \app\framework\database\Update {

      function __construct(\app\framework\database\QueryBuilderParent ...$query){
            $sql = "INSERT INTO Animal (id, nfc) VALUES (:id, :nfc)";

            $this->insert = \app\framework\database\Database::getConnection()->prepare($sql);
            parent::__construct($query);
      }

      function insert(\app\framework\model\Model $model) : String{

          try{
              $this->insert->bindValue(':id', $model->getId());
          }catch(\app\framework\exception\ModelNullException $e){
              $this->insert->bindValue(':id', null);
          }

          try{
              $this->insert->bindValue(':nfc', $model->getNfc());
          }catch(\app\framework\exception\ModelNullException $e){
              $this->insert->bindValue(':nfc', null);
          }

          $this->insert->execute();

          return $this->insert->errorCode();
      }

      function select(\app\framework\model\Model $model) : array{
          try{
              $this->select[0]->bindValue(':id', $model->getId());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->select[0]->bindValue(':nfc', $model->getNfc());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->select[0]->bindValue(':country', $model->getCountry());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->select[0]->bindValue(':serial', $model->getSerial());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->select[0]->bindValue(':working', $model->getWorking());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->select[0]->bindValue(':control', $model->getControl());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->select[0]->bindValue(':product', $model->getProduct());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->select[0]->bindValue(':environment', $model->getEnvironment());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->select[0]->bindValue(':passdate', $model->getPassdate()->format('Y-m-d'));
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->select[0]->bindValue(':reasonofdeath', $model->getReasonofdeath());
          }catch(\app\framework\exception\ModelNullException $e){}

          $this->select[0]->execute();

          $results = $this->select[0]->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, '\app\entity\model\Animal');

          return array($this->select[0]->errorCode(), array($results));
      }

      function update(\app\framework\model\Model $model, \app\framework\model\Model $modelOld) : String {

          try{
              $this->update[0]->bindValue(':idUpdate', $model->getId());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':nfcUpdate', $model->getNfc());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':countryUpdate', $model->getCountry());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':serialUpdate', $model->getSerial());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':workingUpdate', $model->getWorking());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':controlUpdate', $model->getControl());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':productUpdate', $model->getProduct());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':environmentUpdate', $model->getEnvironment());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':passdateUpdate', $model->getPassdate()->format('Y-m-d'));
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':reasonofdeathUpdate', $model->getReasonofdeath());
          }catch(\app\framework\exception\ModelNullException $e){}


          try{
              $this->update[0]->bindValue(':id', $modelOld->getId());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':nfc', $modelOld->getNfc());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':country', $modelOld->getCountry());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':serial', $modelOld->getSerial());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':working', $modelOld->getWorking());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':control', $modelOld->getControl());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':product', $modelOld->getProduct());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':environment', $modelOld->getEnvironment());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':passdate', $modelOld->getPassdate()->format('Y-m-d'));
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':reasonofdeath', $modelOld->getReasonofdeath());
          }catch(\app\framework\exception\ModelNullException $e){}
          $this->update[0]->execute();

          return $this->update[0]->errorCode();
      }
  }
?>
