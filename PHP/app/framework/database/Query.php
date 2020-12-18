<?php
namespace app\framework\database;
require_once(dirname(__FILE__, 1) . '/QueryParent.php');
class Query extends QueryParent{

    private $selectArguments = array();
    private $orderArguments = array();

    public function __construct(\app\framework\model\Model $entity, \app\framework\api\ReadonlyApi $api){
        $this->entity = $entity;
        $this->api = $api;
    }

    public function setSelectArguments(array $arguments = array()) : bool{
        $approvedArguments = $this->api->getFields();

        $this->selectArguments = array();
        if(count($arguments) == 0){
          $this->selectArguments[0][0] = '*';
          return true;
        } else if(count($arguments) <= count($approvedArguments)){
            for($i = 0; $i <= count($arguments) - 1; $i++){
                for($k = 0; $k <= count($approvedArguments) - 1; $k++){
                    if($arguments[$i][0] == $approvedArguments[$k][0]){
                        $this->selectArguments[$i][0] = $approvedArguments[$k][0];
                    }
                }
            }
        }

        if($arguments === $this->selectArguments && $this->selectArguments != array()){
            return true;
        }

        $this->selectArguments = array();
        return false;
    }



    public function setOrderArguments(array $arguments = array()) : bool{
      $approvedArguments = $this->api->getFields();
      $this->orderArguments = array();

      if(count($arguments) != 0 && count($arguments) <= count($approvedArguments)){
          for($i = 0; $i <= count($arguments) - 1; $i++){
              for($k = 0; $k <= count($approvedArguments) - 1; $k++){
                  if(count($arguments[$i]) > 0){
                      if($arguments[$i][0] == $approvedArguments[$k][0]){
                          $this->orderArguments[$i][0] = $approvedArguments[$k][0];
                          $this->orderArguments[$i][1] = (isset($arguments[$i][1]) ? $this->getOrderOperator($arguments[$i][1]) : "asc");
                      }
                  }else{
                      return false;
                  }
              }
          }
      }

      if(count($arguments) === count($this->orderArguments)){
          return true;
      }
      $this->orderArguments = array();
      return false;
    }



    public function getOrderOperator($operator) : String{
      switch($operator){
          case "asc":
            return "asc";
            break;
          case "desc":
            return "desc";
            break;
          default:
            return "asc";
      }
    }


    /**
     * Get the value of Select Arguments
     *
     * @return mixed
     */
    public function getSelectArguments() : array
    {
        return $this->selectArguments;
    }


    /**
     * Get the value of Order Arguments
     *
     * @return mixed
     */
    public function getOrderArguments() : array
    {
        return $this->orderArguments;
    }

}
?>
