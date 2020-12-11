<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__, 4) . '/app/entity/model/Animal.php');
require_once(dirname(__FILE__, 4) . '/app/entity/database/Animal.php');

final class AnimalDatabaseTest extends TestCase
{
    private $database;
    private $mock;
    private $input1;
    private $input2;
    private $input3;

    private $output1;
    private $output2;

    public function setUp() : void{
        $this->mock = $this->createMock('app\framework\database\QueryBuilder');
        $this->mock->expects($this->any())->method('getSql')->will($this->returnValue("SELECT * FROM Animal WHERE id = :id"));
        $this->database = new \app\entity\database\Animal();
        $this->database->assignStatement($this->mock);
        $this->mock = $this->createMock('app\framework\database\QueryBuilderUpdate');
        $this->mock->expects($this->any())->method('getSql')->will(
          $this->returnValue("UPDATE Animal
                              SET id = :idUpdate,
                                  nfc = :nfcUpdate,
                                  country = :countryUpdate,
                                  serial = :serialUpdate,
                                  working = :workingUpdate,
                                  control = :controlUpdate,
                                  product = :productUpdate,
                                  reasonofdeath = :reasonofdeathUpdate,
                                  passdate = :passdateUpdate,
                                  environment = :environmentUpdate
                WHERE id = :id"));
        $this->database->assignStatement($this->mock);

        $this->input1 = new \app\entity\model\Animal();
        $this->input1->setId("ab45d4ce-266c-4499-a40f-fc923751978e");


        $this->input2 = new \app\entity\model\Animal();
        $this->input2->setId("e4c6ef13-2a72-4bdc-99c3-35c3e052b682");
        $this->input2->setNfc("EFGH");

        $this->input3 = new \app\entity\model\Animal();
        $this->input3->setId("ab45d4ce-266c-4499-a40f-fc923751978e");
        $this->input3->setNfc("IJKL");
        $this->input3->setCountry("DE");
        $this->input3->setSerial(9876);
        $this->input3->setWorking(9876);
        $this->input3->setControl(3);
        $this->input3->setReasonofdeath("Child");
        $this->input3->setPassdate("2020-01-03");
        $this->input3->setProduct("Melk");
        $this->input3->setEnvironment("Massa");

        $this->output1 = new \app\entity\model\Animal();
        $this->output1->setId("ab45d4ce-266c-4499-a40f-fc923751978e");
        $this->output1->setNfc("ABCD");
        $this->output1->setCountry("DE");
        $this->output1->setSerial(1234);
        $this->output1->setWorking(1234);
        $this->output1->setControl(1);
        $this->output1->setReasonofdeath("Death");
        $this->output1->setPassdate("2020-01-01");
        $this->output1->setProduct("Melk");
        $this->output1->setEnvironment("Weiland");
    }

    public function testSelect(): void
    {
        $result = $this->database->select($this->input1);



        $this->assertEquals(
            '00000',
            $result[0]
        );
        
        $this->assertEquals(
            array(array($this->output1)),
            $result[1]
        );
    }

    public function testInsert(): void
    {
        $result = $this->database->insert($this->input2);

        $this->assertEquals(
            '0',
            $result[0]
        );
    }

    public function testUpdate(): void
    {
        $result = $this->database->update($this->input3, $this->input1);

        $this->assertEquals(
            '0',
            $result[0]
        );
    }




}
