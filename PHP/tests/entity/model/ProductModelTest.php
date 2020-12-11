<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__, 4) . '/app/entity/model/Product.php');

final class ProductModelTest extends TestCase
{
    private $model;

    public function setUp() : void{
        $this->model = new \app\entity\model\Product();
    }

    public function testProduct(): void
    {
        $this->model->setProduct("1");

        $this->assertEquals(
            "1",
            $this->model->getProduct()
        );
        $this->expectException(\app\framework\exception\ModelNullException::class);
        $this->model->setProduct(null);

        $this->model->getProduct();
    }
}
