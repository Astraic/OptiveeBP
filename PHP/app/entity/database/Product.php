<?php
namespace app\entity\database;
require_once(dirname(__FILE__,3) . '/framework/database/Database.php');
require_once(dirname(__FILE__,3) . '/framework/database/CRUD.php');
require_once(dirname(__FILE__,3) . '/framework/database/Read.php');
require_once(dirname(__FILE__,3) . '/framework/database/Write.php');
require_once(dirname(__FILE__,3) . '/framework/database/Update.php');
require_once(dirname(__FILE__,3) . '/entity/model/Product.php');

  class Product extends \app\framework\database\CRUD implements \app\framework\database\Read,
                                                              \app\framework\database\Write,
                                                              \app\framework\database\Update {

      function __construct(QueryBuilderParent ...$query){
            $sql = "INSERT INTO Product (product) VALUES (:product)";
            $this->insert = \app\framework\database\Database::getConnection()->prepare($sql);
            parent::__construct($query);
      }

      function insert(\app\framework\model\Model $model) : String{
          try{
              $this->insert->bindValue(':product', $model->getProduct());
          }catch(\app\framework\exception\ModelNullException $e){
              $this->insert->bindValue(':product', null);
          }

          $this->insert->execute();

          return $this->insert->errorCode();
      }

      function select(\app\framework\model\Model $model) : array{
          try{
              $this->select[0]->bindValue(':product', $model->getProduct());
          }catch(\app\framework\exception\ModelNullException $e){}

          $this->select[0]->execute();

          $results = $this->select[0]->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, '\app\entity\model\Product');

          return array($this->select[0]->errorCode(), array($results));
      }

      function update(\app\framework\model\Model $model, \app\framework\model\Model $modelOld) : String {
          try{
              $this->update[0]->bindValue(':productUpdate', $model->getProduct());
          }catch(\app\framework\exception\ModelNullException $e){}

          try{
              $this->update[0]->bindValue(':product', $modelOld->getProduct());
          }catch(\app\framework\exception\ModelNullException $e){}

          $this->update[0]->execute();

          return $this->update[0]->errorCode();
      }
  }
?>
