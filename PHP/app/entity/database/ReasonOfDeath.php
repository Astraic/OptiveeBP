<?php
namespace app\entity\database;
require_once(dirname(__FILE__,3) . '/framework/database/Database.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUD.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUInterface.php');
require_once(dirname(__FILE__,3) . '/entity/model/Reasonofdeath.php');

  class Reasonofdeath extends \framework\database\CRUD implements \app\framework\database\Read,
                                                                  \app\framework\database\Write,
                                                                  \app\framework\database\Update {

      function __construct(QueryBuilderParent ...$query){
            $sql = "INSERT INTO Reasonofdeath (reasonofdeath) VALUES (:reasonofdeath)";
            $this->insert = \database\Database::getConnection()->prepare($sql);
            parent::__construct($query);
      }

      function insert(\model\Model $model) : String{
          try{
            $this->insert->bindValue(':reasonofdeath',  $model->getReasonofdeath());
          }catch(ModelNullException $e){
            $this->insert->bindValue(':reasonofdeath',  null);
          }

          $this->insert->execute();

          return $this->insert->errorCode();
      }

      function select(\model\Model $model) : array{
          try{
              $this->select[0]->bindValue(':reasonofdeath', $model->getReasonofdeath());
          }catch(\exception\ModelNullException $e){}

          $this->select[0]->execute();

          $results = $this->select[0]->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'model\Reasonofdeath');

          return array($this->select[0]->errorCode(), array($results));
      }

      function update(\model\Model $model, \model\Model $modelOld) : String {
          try{
              $this->update[0]->bindValue(':reasonofdeathUpdate', $model->getReasonofdeath());
          }catch(\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':reasonofdeath', $modelOld->getReasonofdeath());
          }catch(\exception\ModelNullException $e){}

          $this->update[0]->execute();

          return $this->update[0]->errorCode();
      }
  }
?>
