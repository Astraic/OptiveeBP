<?php
namespace app\entity\database;
require_once(dirname(__FILE__,3) . '/framework/database/Database.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUD.php');
require_once(dirname(__FILE__,3) . '/framework/database/Read.php');
require_once(dirname(__FILE__,3) . '/framework/database/Write.php');
require_once(dirname(__FILE__,3) . '/framework/database/Update.php');
require_once(dirname(__FILE__,3) . '/entity/model/Reasonofdeath.php');

  class Reasonofdeath extends \app\framework\database\CRUD implements \app\framework\database\Read,
                                                                  \app\framework\database\Write,
                                                                  \app\framework\database\Update {

      function __construct(QueryBuilderParent ...$query){
            $sql = "INSERT INTO Reasonofdeath (reasonofdeath) VALUES (:reasonofdeath)";
            $this->insert = \app\framework\database\Database::getConnection()->prepare($sql);
            parent::__construct($query);
      }

      function insert(\app\framework\model\Model $model) : String{
          try{
            $this->insert->bindValue(':reasonofdeath',  $model->getReasonofdeath());
          }catch(\app\framework\exception\ModelNullException $e){
            $this->insert->bindValue(':reasonofdeath',  null);
          }

          $this->insert->execute();

          return $this->insert->errorCode();
      }

      function select(\app\framework\model\Model $model) : array{
          try{
              $this->select[0]->bindValue(':reasonofdeath', $model->getReasonofdeath());
          }catch(\app\framework\exception\ModelNullException $e){}

          $this->select[0]->execute();

          $results = $this->select[0]->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, '\app\entity\model\Reasonofdeath');

          return array($this->select[0]->errorCode(), array($results));
      }

      function update(\app\framework\model\Model $model, \app\framework\model\Model $modelOld) : String {
          try{
              $this->update[0]->bindValue(':reasonofdeathUpdate', $model->getReasonofdeath());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':reasonofdeath', $modelOld->getReasonofdeath());
          }catch(\app\framework\exception\ModelNullException $e){}

          $this->update[0]->execute();

          return $this->update[0]->errorCode();
      }
  }
?>
