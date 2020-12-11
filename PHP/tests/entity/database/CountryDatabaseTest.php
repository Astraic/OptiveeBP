<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__, 4) . '/app/entity/model/Country.php');
require_once(dirname(__FILE__, 4) . '/app/entity/database/Country.php');

final class CountryDatabaseTest extends TestCase
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
        $this->mock->expects($this->any())->method('getSql')->will($this->returnValue("SELECT * FROM Country WHERE code = :code"));
        $this->database = new \app\entity\database\Country();
        $this->database->assignStatement($this->mock);
        $this->mock = $this->createMock('app\framework\database\QueryBuilderUpdate');
        $this->mock->expects($this->any())->method('getSql')->will($this->returnValue("UPDATE Country SET name = :nameUpdate, code = :codeUpdate WHERE code = :code"));
        $this->database->assignStatement($this->mock);

        $this->input1 = new \app\entity\model\Country();
        $this->input1->setCode("NL");

        $this->input2 = new \app\entity\model\Country();
        $this->input2->setCode("BE");
        $this->input2->setName("Belgie");

        $this->input3 = new \app\entity\model\Country();
        $this->input3->setCode("FR");
        $this->input3->setName("Frankrijk");

        $this->output1 = new \app\entity\model\Country();
        $this->output1->setCode("NL");
        $this->output1->setName("Nederland");

        $this->output2 = new \app\entity\model\Country();
        $this->output2->setCode("DE");
        $this->output2->setName("Duitsland");
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
