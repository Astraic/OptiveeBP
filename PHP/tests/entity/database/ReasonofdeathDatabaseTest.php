<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__, 4) . '/app/entity/model/Reasonofdeath.php');
require_once(dirname(__FILE__, 4) . '/app/entity/database/Reasonofdeath.php');

final class ReasonofdeathDatabaseTest extends TestCase
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
        $this->mock->expects($this->any())->method('getSql')->will($this->returnValue("SELECT * FROM Reasonofdeath WHERE reasonofdeath = :reasonofdeath"));
        $this->database = new \app\entity\database\Reasonofdeath();
        $this->database->assignStatement($this->mock);
        $this->mock = $this->createMock('app\framework\database\QueryBuilderUpdate');
        $this->mock->expects($this->any())->method('getSql')->will($this->returnValue("UPDATE Reasonofdeath SET reasonofdeath = :reasonofdeathUpdate WHERE reasonofdeath = :reasonofdeath"));
        $this->database->assignStatement($this->mock);

        $this->input1 = new \app\entity\model\Reasonofdeath();
        $this->input1->setReasonofdeath("Death");

        $this->input2 = new \app\entity\model\Reasonofdeath();
        $this->input2->setReasonofdeath("Sick");

        $this->input3 = new \app\entity\model\Reasonofdeath();
        $this->input3->setReasonofdeath("Mad");

        $this->output1 = new \app\entity\model\Reasonofdeath();
        $this->output1->setReasonofdeath("Death");
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
