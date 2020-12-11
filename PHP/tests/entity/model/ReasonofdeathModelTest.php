<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__, 4) . '/app/entity/model/Reasonofdeath.php');

final class ReasonofdeathModelTest extends TestCase
{
    private $model;

    public function setUp() : void{
        $this->model = new \app\entity\model\Reasonofdeath();
    }

    public function testReasonofdeath(): void
    {
        $this->model->setReasonofdeath("1");

        $this->assertEquals(
            "1",
            $this->model->getReasonofdeath()
        );
        $this->expectException(\app\framework\exception\ModelNullException::class);
        $this->model->setReasonofdeath(null);

        $this->model->getReasonofdeath();
    }
}
