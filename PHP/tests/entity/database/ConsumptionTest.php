<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__,4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,4) . '/app/entity/database/Consumption.php');
require_once(dirname(__FILE__,4) . '/app/entity/model/Consumption.php');

/**
 * Consumption database class tests
 * @author Stephan de Jongh
 */

class ConsumptionTest extends TestCase {

    private $database;
    private $mockSelect;
    private $mockUpdate;
    private $input;
    private $output;

    function setUp() : void {
        $this->mockSelect = $this->createMock('app\framework\database\QueryBuilder');
        $this->mockSelect->expects($this->any())->method('getSql')->will($this
            ->returnValue('SELECT * FROM Consumption WHERE animalid = :animalid AND date = :date AND time = :time'));
        $this->mockUpdate = $this->createMock('app\framework\database\QueryBuilderParent');
        $this->mockUpdate->expects($this->any())->method('getSql')->will($this
            ->returnValue('UPDATE Consumption SET feedid = :feedidUpdate, portion = :portionUpdate, assigned = :assignedUpdate,
                consumption = :consumptionUpdate WHERE animalid = :animalid AND date = :date AND time = :time'));
        $this->database = new \app\entity\database\Consumption();
        $this->database->assignStatement($this->mockSelect);
        $this->database->assignStatement($this->mockUpdate);

        $this->input = new \app\entity\model\Consumption();
        $this->input->setAnimalid("C41416A4-B8CA-4945-A762-BC50B9D17680");
        $this->input->setDate("2019-02-17");
        $this->input->setTime("16:50:20");

        $this->output = new \app\entity\model\Consumption();
        $this->output->setAnimalid("C41416A4-B8CA-4945-A762-BC50B9D17680");
        $this->output->setDate("2019-02-17");
        $this->output->setTime("16:50:20");
        $this->output->setFeedid(4);
        $this->output->setPortion(0.400);
        $this->output->setAssigned(4.400);
        $this->output->setConsumption(4.300);
    }

    function testSelect() : void {
        $result = $this->database->select($this->input);
        $this->assertEquals('00000', $result[0]);
        $this->assertEquals(array(array($this->output)), $result[1]);
    }

    function testInsert() : void {
        $result = $this->database->insert($this->output);
        $this->assertEquals('0', $result[0]);
    }

    function testUpdate() : void {  
        $result = $this->database->update($this->output, $this->input);
        $this->assertEquals('0', $result[0]);
    }
}
?>