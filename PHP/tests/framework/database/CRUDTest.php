<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/framework/exception/NullPointerException.php');
require_once(dirname(__FILE__, 4) . '/app/framework/database/QueryBuilderParent.php');
require_once(dirname(__FILE__, 4) . '/app/framework/database/CRUD.php');
require_once(dirname(__FILE__, 4) . '/tests/Reflection.php');

final class CRUDTest extends TestCase
{
    private $CRUD;
    private $reflection;
    private $mock;
    private $database;

    public function setUp() : void{

        $this->mock = $this->createMock('app\framework\database\QueryBuilderParent');
        $this->CRUD = new \app\framework\database\CRUD();
		    $this->reflection = ReflectionExecuter::getPrivateProperty('app\framework\database\CRUD', 'select');

    }

    public function testAddSelectStatement(): void
    {

        $this->mock->expects($this->exactly(2))->method('getSql')->will($this->returnValue("SELECT * FROM Animal"));
        $this->mock->expects($this->exactly(1))->method('generateSql')->with();

        $this->CRUD->addSelectStatement($this->mock);

        $this->assertNotEquals(
            null,
            $this->reflection
        );
    }

    public function testAddSelectStatementMultiple(): void
    {

        $this->mock->expects($this->exactly(4))->method('getSql')->will($this->returnValue("SELECT * FROM Animal"));
        $this->mock->expects($this->exactly(2))->method('generateSql')->with();

        $this->CRUD->addSelectStatement($this->mock, $this->mock);

        $this->assertNotEquals(
            null,
            $this->reflection
        );
    }
}
