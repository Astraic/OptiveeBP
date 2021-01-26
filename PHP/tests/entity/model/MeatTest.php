<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__,4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,4) . '/app/entity/model/Meat.php');

/**
 * Meat model class tests
 * @author Stephan de Jongh
 */

class MeatTest extends TestCase {

    private $model;

    function setUp() : void {
        $this->model = new \app\entity\model\Meat();
        $this->expectException(\app\framework\exception\ModelNullException::class);
    }

    function testName() : void {
        $this->model->setName("3");
        $this->assertEquals("3", $this->model->getName());
        $this->model->setName(NULL);
        $this->model->getName();  
    }
}
?>