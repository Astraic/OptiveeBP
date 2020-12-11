<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/entity/model/Animal.php');

final class ModelTest extends TestCase
{
    private $model;

    public function setUp() : void{
        $this->model = new \app\entity\model\Animal();
    }

    public function testEmpty(): void
    {

        $json = $this->model->jsonSerialize();

        $this->assertEquals(
            "{}",
            json_encode($json)
        );
    }

    public function testFilled(): void
    {

        $this->model->setNfc("1234");
        $this->model->setId("5678");
        $this->model->setCountry("NL");
        $this->model->setSerial("abcd");

        $json = $this->model->jsonSerialize();

        $this->assertEquals(
            '{"country":"NL","serial":"abcd","nfc":"1234","id":"5678"}',
            json_encode($json)
        );

    }
}
