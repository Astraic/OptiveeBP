<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__, 4) . '/app/entity/model/Animal.php');

final class AnimalModelTest extends TestCase
{
    private $model;
    private $reflection;
    private $mock;
    private $database;

    public function setUp() : void{
        $this->model = new \app\entity\model\Animal();
    }

    public function testId(): void
    {
        $this->model->setId(1);

        $this->assertEquals(
            1,
            $this->model->getId()
        );
        $this->expectException(\app\framework\exception\ModelNullException::class);
        $this->model->setId(null);

        $this->model->getId();


    }

    public function testNfc(){
        $this->model->setNfc("1");


        $this->assertEquals(
            "1",
            $this->model->getNfc()
        );
        $this->expectException(\app\framework\exception\ModelNullException::class);
        $this->model->setNfc(null);

        $this->model->getNfc();


    }

    public function testCountry(){
        $this->model->setCountry("1");


        $this->assertEquals(
            "1",
            $this->model->getCountry()
        );
        $this->expectException(\app\framework\exception\ModelNullException::class);
        $this->model->setCountry(null);

        $this->model->getCountry();


    }

    public function testSerial(){
        $this->model->setSerial("1");


        $this->assertEquals(
            "1",
            $this->model->getSerial()
        );

                $this->expectException(\app\framework\exception\ModelNullException::class);
        $this->model->setSerial(null);

        $this->model->getSerial();

    }

    public function testWorking(){
        $this->model->setWorking("1");


        $this->assertEquals(
            "1",
            $this->model->getWorking()
        );
        $this->expectException(\app\framework\exception\ModelNullException::class);
        $this->model->setWorking(null);

        $this->model->getWorking();


    }

    public function testControl(){
        $this->model->setControl("1");


        $this->assertEquals(
            "1",
            $this->model->getControl()
        );
        $this->expectException(\app\framework\exception\ModelNullException::class);
        $this->model->setControl(null);

        $this->model->getControl();


    }

    // public function testProduct(){
    //     $this->model->setProduct();
    //
    //
    //     $this->assertEquals(
    //         "1",
    //         $this->model->getControl()
    //     );

        // $this->model->setId(null);
        //
        // $this->model-getId();
        //
        // $this->expectException(\app\framework\exception\ModelNullException::class);
    // }

    public function testPassdate(){
        $date = new \DateTime();
        $this->model->setPassdate($date);

        $this->assertEquals(
            $date,
            $this->model->getPassdate()
        );
        $this->expectException(\app\framework\exception\ModelNullException::class);
        $this->model->setPassdate(null);

        $this->model->getPassdate();


    }

    // public function testEnvironment(){
    //     $this->model->setEnvironment(*product*);
    //
    //     $this->assertEquals(
    //         (*environment*),
    //         $this->model->getPassdate()
    //     );
        //
        // $this->model->setId(null);
        //
        // $this->model-getId();
        //
        // $this->expectException(\app\framework\exception\ModelNullException::class);
    // }

    // public function testReasonofdeath(){
    //     $this->model->setEnvironment(*reasonofdeath*);
    //
    //     $this->assertEquals(
    //         (*reasonofdeath*),
    //         $this->model->getPassdate()
    //     );
        //
        // $this->model->setId(null);
        //
        // $this->model-getId();
        //
        // $this->expectException(\app\framework\exception\ModelNullException::class);
    // }
}
