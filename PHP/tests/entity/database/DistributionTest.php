<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__,4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,4) . '/app/entity/database/Distribution.php');
require_once(dirname(__FILE__,4) . '/app/entity/model/Distribution.php');

/**
 * Distribution database class tests
 * @author Stephan de Jongh
 */

class DistributionTest extends TestCase {

    private $database;
    private $mockSelect;
    private $mockUpdate;
    private $input;
    private $output;

    function setUp() : void {
        $this->mockSelect = $this->createMock('app\framework\database\QueryBuilder');
        $this->mockSelect->expects($this->any())->method('getSql')->will($this
            ->returnValue('SELECT * FROM Distribution WHERE animalid = :animalid'));
        $this->mockUpdate = $this->createMock('app\framework\database\QueryBuilderParent');
        $this->mockUpdate->expects($this->any())->method('getSql')->will($this
            ->returnValue('UPDATE Distribution SET feedid = :feedidUpdate, portion = :portionUpdate, 
                assigned = :assignedUpdate WHERE animalid = :animalid'));
        $this->database = new \app\entity\database\Distribution();
        $this->database->assignStatement($this->mockSelect);
        $this->database->assignStatement($this->mockUpdate);
        
        $this->input = new \app\entity\model\Distribution();
        $this->input->setAnimalid("C41416A4-B8CA-4945-A762-BC50B9D17680");

        $this->output = new \app\entity\model\Distribution();
        $this->output->setAnimalid("C41416A4-B8CA-4945-A762-BC50B9D17680");
        $this->output->setFeedid(5);
        $this->output->setPortion(0.700);
        $this->output->setAssigned(4.200);
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