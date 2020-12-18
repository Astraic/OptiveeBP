<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__,4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,4) . '/app/entity/model/Quality.php');

/**
 * Quality model class tests
 * @author Stephan de Jongh
 */

class QualityTest extends TestCase {

    private $model;
    private $date;

    function setUp() : void {
        $this->model = new \app\entity\model\Quality();
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

    function testCatname() : void {
        $this->model->setCatname("A");
        $this->assertEquals("A", $this->model->getCatname());
        $this->model->setCatname(NULL);
        $this->model->getCatname();  
    }

    function testFatname() : void {
        $this->model->setFatname("O");
        $this->assertEquals("O", $this->model->getFatname());
        $this->model->setFatname(NULL);
        $this->model->getFatname();  
    }

    function testMeatname() : void {
        $this->model->setMeatname("3");
        $this->assertEquals("3", $this->model->getMeatname());
        $this->model->setMeatname(NULL);
        $this->model->getMeatname();  
    }

    function testAmount() : void {
        $this->model->setAmount(165);
        $this->assertEquals(165, $this->model->getAmount());
        $this->model->setAmount(NULL);
        $this->model->getAmount();  
    }
}
?>