<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__,4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,4) . '/app/entity/model/Consumption.php');

/**
 * Consumption model class tests
 * @author Stephan de Jongh
 */

class ConsumptionTest extends TestCase {

    private $model;
    private $date;

    function setUp() : void {
        $this->model = new \app\entity\model\Consumption();
        $this->date = new \DateTime("now");
        $this->expectException(\app\framework\exception\ModelNullException::class);
    }

    function testAnimalid() : void {
        $this->model->setAnimalid("ab45d4ce-266c-4499-a40f-fc923751978e");
        $this->assertEquals("ab45d4ce-266c-4499-a40f-fc923751978e", $this->model->getAnimalid());
        $this->model->setAnimalid(NULL);
        $this->model->getAnimalid();  
    }

    function testDate() : void {
        $date = $this->date->format("Y-m-d");
        $this->model->setDate($date);
        $this->assertEquals($date, $this->model->getDate());
        $this->model->setDate(NULL);
        $this->model->getDate();  
    }
    
    function testTime() : void {
        $time = $this->date->format("H:i:s");
        $this->model->setTime($time);
        $this->assertEquals($time, $this->model->getTime());
        $this->model->setTime(NULL);
        $this->model->getTime();  
    }

    function testFeedid() : void {
        $this->model->setFeedid(17);
        $this->assertEquals(17, $this->model->getFeedid());
        $this->model->setFeedid(NULL);
        $this->model->getFeedid();  
    }

    function testPortion() : void {
        $this->model->setPortion(0.500);
        $this->assertEquals(0.500, $this->model->getPortion());
        $this->model->setPortion(NULL);
        $this->model->getPortion();  
    }

    function testAssigned() : void {
        $this->model->setAssigned(4.500);
        $this->assertEquals(4.500, $this->model->getAssigned());
        $this->model->setAssigned(NULL);
        $this->model->getAssigned();  
    }

    function testConsumption() : void {
        $this->model->setConsumption(3.780);
        $this->assertEquals(3.780, $this->model->getConsumption());
        $this->model->setConsumption(NULL);
        $this->model->getConsumption();  
    }
}
?>