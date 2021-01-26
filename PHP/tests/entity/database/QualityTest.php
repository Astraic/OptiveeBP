<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__,4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,4) . '/app/entity/database/Quality.php');
require_once(dirname(__FILE__,4) . '/app/entity/model/Quality.php');

/**
 * Quality database class tests
 * @author Stephan de Jongh
 */

class QualityTest extends TestCase {

    private $database;
    private $mockSelect;
    private $mockUpdate;
    private $input;
    private $output;

    function setUp() : void {
        $this->mockSelect = $this->createMock('app\framework\database\QueryBuilder');
        $this->mockSelect->expects($this->any())->method('getSql')->will($this
            ->returnValue('SELECT * FROM Quality WHERE animalid = :animalid'));
        $this->mockUpdate = $this->createMock('app\framework\database\QueryBuilderParent');
        $this->mockUpdate->expects($this->any())->method('getSql')->will($this
            ->returnValue('UPDATE Quality SET catname = :catnameUpdate, fatname = :fatnameUpdate, 
                meatname = :meatnameUpdate, amount = :amountUpdate WHERE animalid = :animalid'));
        $this->database = new \app\entity\database\Quality();
        $this->database->assignStatement($this->mockSelect);
        $this->database->assignStatement($this->mockUpdate);
        
        $this->input = new \app\entity\model\Quality();
        $this->input->setAnimalid("C41416A4-B8CA-4945-A762-BC50B9D17680");

        $this->output = new \app\entity\model\Quality();
        $this->output->setAnimalid("C41416A4-B8CA-4945-A762-BC50B9D17680");
        $this->output->setDate("2021-01-01");
        $this->output->setTime("19:50:45");
        $this->output->setCatname("B");
        $this->output->setFatname("3");
        $this->output->setMeatname("O");
        $this->output->setAmount(84.60);
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