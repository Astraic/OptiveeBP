<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__,4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,4) . '/app/entity/model/Feed.php');

/**
 * Feed model class tests
 * @author Stephan de Jongh
 */

class FeedTest extends TestCase {

    private $model;

    function setUp() : void {
        $this->model = new \app\entity\model\Feed();
        $this->expectException(\app\framework\exception\ModelNullException::class);
    }

    function testId() : void {
        $this->model->setId(17);
        $this->assertEquals(17, $this->model->getId());
        $this->model->setId(NULL);
        $this->model->getId();  
    }

    function testName() : void {
        $this->model->setName("Vitamix Deluxe");
        $this->assertEquals("Vitamix Deluxe", $this->model->getName());
        $this->model->setName(NULL);
        $this->model->getName();  
    }
}
?>