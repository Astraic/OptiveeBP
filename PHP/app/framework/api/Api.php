<?php
namespace app\framework\api;

require_once(dirname(__FILE__, 2) . '/database/Query.php');
require_once(dirname(__FILE__, 2) . '/database/QueryUpdate.php');
require_once(dirname(__FILE__, 2) . '/database/QueryBuilder.php');
require_once(dirname(__FILE__, 2) . '/database/QueryBuilderUpdate.php');
require_once(dirname(__FILE__, 2) . '/exception/NullPointerException.php');
abstract class Api {

      protected $database = null;
      protected $select = null;
      protected $where = null;
      protected $order = null;
      protected $json = null;
      protected $delete = null;

      public function __construct(){}

      public function setHttpCode($code) {
          switch($code){
              case '00':
                  //SQL query succesful
                  header('HTTP/1.0 200 OK');
                  break;
              case '01':
                  //just a warning continue
                  header('HTTP/1.0 200 OK');
                  break;
              case '02':
                  //the requested data does not exist
                  header('HTTP/1.0 404 Not Found');
                  break;
              case '07':
                  //Not really used, here for future reasons
                  header('HTTP/1.0 500 Internal Server Error');
                  break;
              case 2002:
                  //could not log in to the mysql mariadb database
                  header('HTTP/1.0 503 Service Unavailable');
                  echo json_encode("The requested server is temporary unavailable, we are working hard on resolving this issue. If it presists please contact customer service");
                  break;
              case '08':
                  //could not create connection to db
                  //most likely an error with connection state
                  header('HTTP/1.0 503 Service Unavailable');
                  echo json_encode("The requested server is temporary unavailable, we are working hard on resolving this issue. If it presists please contact customer service");
                  break;
              case '22':
                  //Data Exception
                  header('HTTP/1.0 400 Bad Request');
                  echo json_encode("The inserted, updated or deleted data is invalid");
                  break;
              case '23':
                  //Constraint vialation
                  header('HTTP/1.0 400 Bad Request');
                  echo json_encode("The inserted, updated or deleted data violates an integrity constraint");
                  break;
              default:
                  //generic error to catch all
                  header('HTTP/1.0 500 Internal Server error');
                  echo json_encode("An unknown error occured, please contact customer support if the error presists");
                  echo json_encode($code);
                  break;
          }
          die;
      }

      public function buildQuery(\app\framework\model\Model $entity) : \app\framework\database\QueryBuilder{
          $query = new \app\framework\database\Query($entity, $this);
          //check if the user passed a select restriction
          if(isset($this->select)){
              //rebuild the arguments in array form
              $arguments = $this->rebuildArguments($this->select);
              //if all arguments are valid continue else throw exception
              if(!$query->setSelectArguments($arguments)){
                  throw new \app\framework\exception\NullPointerException("Select has invalid argument");
              }
          }else{
              if(!$query->setSelectArguments()){
                  throw new \app\framework\exception\NullPointerException("Select has invalid argument");
              }
          }
          //check if the user passed a where clause
          if(isset($this->where)){
              //rebuild arguments in array form
              $arguments = $this->rebuildArguments($this->where);
              //if all arguments are valid continue else throw exception
              if(!$query->setWhereArguments($arguments)){
                  throw new \app\framework\exception\NullPointerException("Where has invalid argument");
              }
          }
          //check if the user set an order by clause
          if(isset($this->order)){
              //rebuild the arguments in array form
              $arguments = $this->rebuildArguments($this->order);
              //check if all arguments are valid or throw an exception
              if(!$query->setOrderArguments($arguments)){
                  throw new \app\framework\exception\NullPointerException("Order has invalid argument");
              }
          }

          $queryBuilder = new \app\framework\database\QueryBuilder($query);
          return $queryBuilder;
      }

      public function buildUpdate(\app\framework\model\Model $entity) : \app\framework\database\QueryBuilderUpdate{
          $query = new \app\framework\database\QueryUpdate($entity, $this);
          //check if the user passed a set restriction
          if(isset($this->json)){
              //rebuild the arguments in array form
              $arguments = $this->rebuildArgumentsFromJson($this->json);
              //if all arguments are valid continue else throw exception
              if(!$query->setSetArguments($arguments)){
                  throw new \app\framework\exception\NullPointerException("Set has invalid argument");
              }
          }else {
            //set is required throw null pointer if it was not passed
              throw new \app\framework\exception\NullPointerException("Set parameter is not passed");
          }
          //check if the user passed a where clause
          if(isset($this->where)){
              //rebuild arguments in array form
              $arguments = $this->rebuildArguments($this->where);
              //if all arguments are valid continue else throw exception
              if(!$query->setWhereArguments($arguments)){
                  throw new \app\framework\exception\NullPointerException("Where has invalid argument");
              }
          }else {
            //where is required throw null pointer if it was not passed
              throw new \app\framework\exception\NullPointerException("Where argument was not passed");
          }

          //Create the object that can build this query
          $queryBuilder = new \app\framework\database\QueryBuilderUpdate($query);

          return $queryBuilder;
      }


      //rebuild the arguments from string to array
      public function rebuildArguments(String $get_parameter) : array{
          $parameterFull = urlencode($get_parameter);
          $parameterFull = str_replace(" ", "%20", $parameterFull);
          $parameterFull = urldecode($parameterFull);

          //seperate the different columns
          $parameters = \explode('.', $get_parameter);

          //seperate the different parts of a clause
          foreach($parameters as $key => $value){
              $parameters[$key] = \explode('-', $value, 3);
          }

          return $parameters;
      }

      public function rebuildArgumentsFromJson(String $json){
        //convert json to Asso Array
        $argumentsUnformated = json_decode($this->json, true);
        //create new array
        $arguments = array();

        //convert Asso Array to Multidementional array
        //Format [['colname', 'colvalue'], ['colname', 'colvalue'], ['colname', 'colvalue']]
        foreach($argumentsUnformated[0] as $key => $value){
            $arguments[] = [$key, $value];
        }
        return $arguments;
      }
  }
?>
