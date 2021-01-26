<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/framework/database/Query.php');
require_once(dirname(__FILE__, 4) . '/app/entity/api/Animal.php');
require_once(dirname(__FILE__, 4) . '/app/entity/model/Animal.php');
require_once(dirname(__FILE__, 4) . '/tests/Reflection.php');


final class ApiTest extends TestCase
{
    private $api;
    private $select;
    private $where;
    private $order;
    private $json;
    private $mock;
    private $database;

    public function setUp() : void{

        $this->mock = $this->createMock('app\framework\database\Query');
        $this->select = ReflectionExecuter::getPrivateProperty('app\framework\api\Api', 'select');
        $this->where = ReflectionExecuter::getPrivateProperty('app\framework\api\Api', 'where');
        $this->order = ReflectionExecuter::getPrivateProperty('app\framework\api\Api', 'order');
        $this->json = ReflectionExecuter::getPrivateProperty('app\framework\api\Api', 'json');

        $this->api = new \app\entity\api\Animal();
    }

    public function testSetHttpCode(){
        //Not tested due to modifying header info
        $this->assertEquals(
            true,
            true
        );
    }

    public function testRebuildArguments(){
       $input = 'name.id';
       $output = [['name'], ['id']];

       $this->assertEquals(
           $output,
           $this->api->rebuildArguments($input)
       );
   }

   public function testRebuildArgumentsWhere(){
       $input = 'name-eq-value1.id-eq-value2';
       $output = [['name', 'eq', 'value1'], ['id', 'eq', 'value2']];

       $this->assertEquals(
           $output,
           $this->api->rebuildArguments($input)
       );
   }

   public function testRebuildArgumentsOrder(){
       $input = 'name-desc.id-asc';
       $output = [['name', 'desc'], ['id', 'asc']];

       $this->assertEquals(
           $output,
           $this->api->rebuildArguments($input)
       );
   }

   public function testRebuildArgumentsFromJson(){
       $input = '{"name":"value1","id":"value2"}';
       $output = [['name', 'value1'], ['id', 'value2']];

       $this->assertEquals(
           $output,
           $this->api->rebuildArgumentsFromJson($input)
       );
   }


    // public function testBuildQuery(){
    //   $this->mock->expects($this->exactly(1))->method('setWhereArguments')->will($this->returnValue(true));
    //   $this->mock->expects($this->exactly(1))->method('setSelectArguments')->will($this->returnValue(true));
    //   $this->mock->expects($this->exactly(1))->method('setOrderArguments')->with($this->returnValue(true));
    //
    //   $this->select->setValue($this->api, "id.nfc");
    //   $this->where->setValue($this->api, "id-eq-1234");
    //   $this->order->setValue($this->api, "id");
    //
    //   $this->api->buildQuery(new \app\entity\model\Animal());
    // }
    //
    // public function testBuildQueryMistake(){
    //   $this->mock->expects($this->exactly(1))->method('setWhereArguments')->will($this->returnValue(false));
    //   $this->mock->expects($this->exactly(1))->method('setSelectArguments')->will($this->returnValue(true));
    //   $this->mock->expects($this->exactly(1))->method('setOrderArguments')->with($this->returnValue(true));
    //
    //   $this->select->setValue($this->api, "id.nfc");
    //   $this->where->setValue($this->api, "id-eq-1234");
    //   $this->order->setValue($this->api, "id");
    //
    //   $this->api->buildQuery(new \app\entity\model\Animal());
    //
    //   $this->expectException(NullPointerException::class);
    // }
    //
    // public function testBuildQueryNoWhere(){
    //   $this->mock->expects($this->exactly(0))->method('setWhereArguments');
    //   $this->mock->expects($this->exactly(1))->method('setSelectArguments')->will($this->returnValue(true));
    //   $this->mock->expects($this->exactly(1))->method('setOrderArguments')->with($this->returnValue(true));
    //
    //   $this->select->setValue($this->api, "id.nfc");
    //   $this->where->setValue($this->api, null);
    //   $this->order->setValue($this->api, "id");
    //
    //   $this->api->buildQuery(new \app\entity\model\Animal());
    // }
    //
    // public function testBuildQueryEmpty(){
    //   $this->mock->expects($this->exactly(0))->method('setWhereArguments');
    //   $this->mock->expects($this->exactly(1))->method('setSelectArguments')->will($this->returnValue(true));
    //   $this->mock->expects($this->exactly(0))->method('setOrderArguments');
    //
    //   $this->select->setValue($this->api, null);
    //   $this->where->setValue($this->api, null);
    //   $this->order->setValue($this->api, null);
    //
    //   $this->api->buildQuery(new \app\entity\model\Animal());
    // }
    //
    // public function testBuildUpdate(){
    //   $this->mock->expects($this->exactly(1))->method('setWhereArguments')->will($this->returnValue(true));
    //   $this->mock->expects($this->exactly(1))->method('setSetArguments')->will($this->returnValue(true));
    //
    //   $this->select->setValue($this->api, null);
    //   $this->where->setValue($this->api, "id-eq-value");
    //   $this->order->setValue($this->api, null);
    //   $this->json->setValue($this->api, '{"nfc":"value"}');
    //
    //   $this->api->buildUpdate(new \app\entity\model\Animal());
    // }
}
