<?php
namespace app\framework\database;
abstract class QueryParent{
  protected $whereArguments = array();
  protected $entity;
  protected $api;

  public function setWhereArguments(array $arguments = array()) : bool{
    $approvedArguments = $this->api->getFields();
    $this->whereArguments = array();
    $skipper = false;
    if(count($arguments) != 0 && count($arguments) <= count($approvedArguments)){
        for($i = 0; $i <= count($arguments) - 1; $i++){
            for($k = 0; $k <= count($approvedArguments) - 1; $k++){

                if(count($arguments[$i]) == 3){
                    if($arguments[$i][0] == $approvedArguments[$k][0]){
                        $this->whereArguments[$i][0] = $approvedArguments[$k][0];
                        $this->whereArguments[$i][1] = $this->getComparisonOperator($arguments[$i][1]);
                        if($arguments[$i][0] == 'password'){
                            unset($this->whereArguments[$i]);
                            $skipper = true;
                        }
                    }
                }else{
                    return false;
                }

            }
        }
    }
    if(($skipper && count($arguments) - 1 === count($this->whereArguments)) || count($arguments) === count($this->whereArguments)){

        return true;
    }
    $this->whereArguments = array();
    return false;
  }

  public function getComparisonOperator($operator) : String{
      switch($operator){
          case "eq":
            return "=";
            break;
          case "sm":
            return "<";
            break;
          case "gr":
            return ">";
            break;
          default:
            throw new \app\framework\exception\NullPointerException("The request send had an illigal operator");
            break;
      }

   }

  /**
   * Get the value of Where Arguments
   *
   * @return mixed
   */
  public function getWhereArguments() : array
  {
      return $this->whereArguments;
  }

  public function getEntity() : \app\framework\model\Model{
      return $this->entity;
  }


}
?>
