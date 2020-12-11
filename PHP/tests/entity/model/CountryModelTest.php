<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__, 4) . '/app/entity/model/Country.php');

final class CountryModelTest extends TestCase
{
    private $model;

    public function setUp() : void{
        $this->model = new \app\entity\model\Country();
    }

    public function testCode(): void
    {
        $this->model->setCode("1");

        $this->assertEquals(
            "1",
            $this->model->getCode()
        );
        $this->expectException(\app\framework\exception\ModelNullException::class);
        $this->model->setCode(null);

        $this->model->getCode();
    }

    public function testName(): void
    {
        $this->model->setName("1");

        $this->assertEquals(
            "1",
            $this->model->getName()
        );
        $this->expectException(\app\framework\exception\ModelNullException::class);
        $this->model->setName(null);

        $this->model->getName();
    }


}
