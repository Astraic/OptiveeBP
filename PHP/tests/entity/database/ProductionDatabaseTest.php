<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__, 4) . '/app/entity/model/Production.php');
require_once(dirname(__FILE__, 4) . '/app/entity/database/Production.php');

final class ProductionDatabaseTest extends TestCase
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
        $this->mock->expects($this->any())->method('getSql')->will($this->returnValue("SELECT * FROM Production WHERE animal = :animal"));
        $this->database = new \app\entity\database\Production();
        $this->database->assignStatement($this->mock);
        $this->mock = $this->createMock('app\framework\database\QueryBuilderUpdate');
        $this->mock->expects($this->any())->method('getSql')->will($this->returnValue(
          "UPDATE Production SET animal = :animalUpdate,
                                 product = :productUpdate,
                                 production = :productionUpdate,
                                 productiondatetime = :productiondatetimeUpdate
                              WHERE animal = :animal"));
        $this->database->assignStatement($this->mock);

        $this->input1 = new \app\entity\model\Production();
        $this->input1->setAnimal("ab45d4ce-266c-4499-a40f-fc923751978e");

        $this->input2 = new \app\entity\model\Production();
        $this->input3->setAnimal("ab45d4ce-266c-4499-a40f-fc923751978e");
        $this->input3->setProduct("Melk");
        $this->input3->setProduction(2);
        $this->input3->setProductiondatetime("Melk");

        $this->input3 = new \app\entity\model\Production();
        $this->input3->setAnimal("ab45d4ce-266c-4499-a40f-fc923751978e");
        $this->input3->setProduct("Melk");
        $this->input3->setProduction(1);
        $this->input3->setProductiondatetime("2020-01-03");

        $this->output1 = new \app\entity\model\Production();
        $this->output1->setAnimal("ab45d4ce-266c-4499-a40f-fc923751978e");
        $this->output1->setProduct("Melk");
        $this->output1->setProduction(3);
        $this->output1->setProductiondatetime("2020-01-03");
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
