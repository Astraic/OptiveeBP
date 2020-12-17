<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__,4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,4) . '/app/entity/model/Distribution.php');

/**
 * Distribution model class tests
 * @author Stephan de Jongh
 */

class DistributionTest extends TestCase {

    private $model;

    function setUp() : void {
        $this->model = new \app\entity\model\Distribution();
        $this->expectException(\app\framework\exception\ModelNullException::class);
    }

    function testAnimalid() : void {
        $this->model->setAnimalid("ab45d4ce-266c-4499-a40f-fc923751978e");
        $this->assertEquals("ab45d4ce-266c-4499-a40f-fc923751978e", $this->model->getAnimalid());
        $this->model->setAnimalid(NULL);
        $this->model->getAnimalid();  
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
}
?>