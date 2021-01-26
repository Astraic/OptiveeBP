<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__, 4) . '/app/entity/model/Production.php');

final class ProductionModelTest extends TestCase
{
    private $model;

    public function setUp() : void{
        $this->model = new \app\entity\model\Production();
    }

    // public function testProduct(): void
    // {
    //     $this->model->setProduct("1");
    //
    //     $this->assertEquals(
    //         "1",
    //         $this->model->getProduct()
    //     );
    //     $this->expectException(\app\framework\exception\ModelNullException::class);
    //     $this->model->setProduct(null);
    //
    //     $this->model->getProduct();
    // }

    public function testProduction(): void
    {
        $this->model->setProduction(1);

        $this->assertEquals(
            1,
            $this->model->getProduction()
        );
        $this->expectException(\app\framework\exception\ModelNullException::class);
        $this->model->setProduction(null);

        $this->model->getProduction();
    }

    public function testDateTime(): void
    {
        $this->model->setProductiondatetime(1);

        $this->assertEquals(
            1,
            $this->model->getProductiondatetime()
        );
        $this->expectException(\app\framework\exception\ModelNullException::class);
        $this->model->setProductionDateTime(null);

        $this->model->getProductiondatetime();
    }


}
