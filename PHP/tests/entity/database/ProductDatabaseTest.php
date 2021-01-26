<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__, 4) . '/app/entity/model/Product.php');
require_once(dirname(__FILE__, 4) . '/app/entity/database/Product.php');

final class ProductDatabaseTest extends TestCase
{
    private $database;
    private $mock;
    private $input1;
    private $input2;
    private $input3;

    private $output1;
    private $output2;

    public function setUp() : void{
        $this->mock = $this->createMock('app\framework\database\QueryBuilder');
        $this->mock->expects($this->any())->method('getSql')->will($this->returnValue("SELECT * FROM Product WHERE product = :product"));
        $this->database = new \app\entity\database\Product();
        $this->database->assignStatement($this->mock);
        $this->mock = $this->createMock('app\framework\database\QueryBuilderUpdate');
        $this->mock->expects($this->any())->method('getSql')->will($this->returnValue("UPDATE Product SET product = :productUpdate WHERE product = :product"));
        $this->database->assignStatement($this->mock);

        $this->input1 = new \app\entity\model\Product();
        $this->input1->setProduct("Melk");

        $this->input2 = new \app\entity\model\Product();
        $this->input2->setProduct("Vlees");

        $this->input3 = new \app\entity\model\Product();
        $this->input3->setProduct("Kind");

        $this->output1 = new \app\entity\model\Product();
        $this->output1->setProduct("Melk");
    }

    public function testSelect(): void
    {
        $result = $this->database->select($this->input1);



        $this->assertEquals(
            '00000',
            $result[0]
        );

        $this->assertEquals(
            array(array($this->output1)),
            $result[1]
        );
    }

    public function testInsert(): void
    {
        $result = $this->database->insert($this->input2);

        $this->assertEquals(
            '0',
            $result[0]
        );
    }

    public function testUpdate(): void
    {
        $result = $this->database->update($this->input3, $this->input1);

        $this->assertEquals(
            '0',
            $result[0]
        );
    }




}
