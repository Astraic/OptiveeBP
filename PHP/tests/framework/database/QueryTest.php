<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/framework/exception/NullPointerException.php');
require_once(dirname(__FILE__, 4) . '/app/framework/database/Query.php');
require_once(dirname(__FILE__, 4) . '/app/entity/model/Animal.php');
require_once(dirname(__FILE__, 4) . '/app/entity/api/NewAnimal.php');

final class QueryTest extends TestCase
{

    protected $query;

    public function setUp() : void{
        $this->query = new \app\framework\database\Query(new \app\entity\model\Animal(), new \app\entity\api\NewAnimal());
    }

    public function testSetSelectArguments(): void
    {
        $good_input = [['nfc'], ['id']];
        $this->assertEquals(
            true,
            $this->query->setSelectArguments($good_input)
        );
        $this->assertEquals(
            $good_input,
            $this->query->getSelectArguments()
        );
    }

    public function testSetSelectArgumentsBadArguments(): void
    {
        $good_input = [['illigal_column_name'], ['id']];
        $this->assertEquals(
            false,
            $this->query->setSelectArguments($good_input)
        );

        $this->assertEquals(
            array(),
            $this->query->getSelectArguments()
        );
    }

    public function testSetSelectArgumentsNoArguments(): void
    {
        $good_input = [];
        $this->assertEquals(
            true,
            $this->query->setSelectArguments($good_input)
        );
        $this->assertEquals(
            [['*']],
            $this->query->getSelectArguments()
        );
    }

    public function testSetWhereArguments(): void
    {
        $good_input = [['nfc', 'eq', 'test'], ['id', 'gr', 'test']];
        $good_output = [['nfc', '='], ['id', '>']];
        $this->assertEquals(
            true,
            $this->query->setWhereArguments($good_input)
        );
        $this->assertEquals(
            $good_output,
            $this->query->getWhereArguments()
        );
    }

    public function testSetWhereArgumentsBadArguments(): void
    {
        $bad_input = [['illigal_column_name', 'eq', 'test'], ['id', 'eq']];
        $this->assertEquals(
            false,
            $this->query->setWhereArguments($bad_input)
        );

        $this->assertEquals(
            array(),
            $this->query->getWhereArguments()
        );
    }

    public function testSetWhereArgumentsNoEquals(): void
    {
        $bad_input = [['nfc'], ['id', 'eq', 'test']];
        //$this->expectException(\exception\NullPointerException::class);
        $this->assertEquals(
            false,
            $this->query->setWhereArguments($bad_input)
        );

        $this->assertEquals(
            array(),
            $this->query->getWhereArguments()
        );
    }

    public function testSetWhereArgumentsIlligalOperator(): void
    {
        $bad_input = [['nfc', 'not_existing_operator', 'test'], ['id', 'eq', 'test']];
        $this->expectException(\app\framework\exception\NullPointerException::class);
        $this->assertEquals(
            false,
            $this->query->setWhereArguments($bad_input)
        );
        $this->assertEquals(
            array(),
            $this->query->getWhereArguments()
        );
    }

    public function testSetWhereArgumentsTooManyColumns(): void
    {
        $bad_input = [['nfc', 'gr', 'test'], ['id', 'eq', 'test'], ['nfc', 'gr', 'test']];
        $this->assertEquals(
            false,
            $this->query->setWhereArguments($bad_input)
        );
        $this->assertEquals(
            array(),
            $this->query->getWhereArguments()
        );
    }

    public function testSetWhereArgumentsValidFewerColumns(): void
    {
        $good_input = [['nfc', 'gr', 'test']];
        $good_output = [['nfc', '>']];
        $this->assertEquals(
            true,
            $this->query->setWhereArguments($good_input)
        );
        $this->assertEquals(
            $good_output,
            $this->query->getWhereArguments()
        );
    }

    public function testSetOrderArguments(): void
    {
        $good_input = [['id', 'desc'], ['nfc', 'asc']];
        $good_output = [['id', 'desc'], ['nfc', 'asc']];
        $this->assertEquals(
            true,
            $this->query->setOrderArguments($good_input)
        );
        $this->assertEquals(
            $good_output,
            $this->query->getOrderArguments()
        );
    }

    public function testSetOrderArgumentsBadArguments(): void
    {
        $input = [['illigal_column_name', 'desc'], ['nfc', 'asc']];
        $output = array();
        $this->assertEquals(
            false,
            $this->query->setOrderArguments($input)
        );
        $this->assertEquals(
            $output,
            $this->query->getOrderArguments()
        );
    }

    public function testSetOrderArgumentsMissingSort(): void
    {
        $input = [['id'], ['nfc', 'desc']];
        $output = [['id', 'asc'], ['nfc', 'desc']];
        $this->assertEquals(
            true,
            $this->query->setOrderArguments($input)
        );
        $this->assertEquals(
            $output,
            $this->query->getOrderArguments()
        );
    }

    public function testSetOrderArgumentsIlligalOperator(): void
    {
        $input = [['nfc', 'illigal_operator'], ['id', 'asc']];
        $output = [['nfc', 'asc'], ['id', 'asc']];
        $this->assertEquals(
            true,
            $this->query->setOrderArguments($input)
        );
        $this->assertEquals(
            $output,
            $this->query->getOrderArguments()
        );
    }

    public function testSetOrderArgumentsFewerColumns(): void
    {
        $input = [['nfc', 'asc']];
        $output = [['nfc', 'asc']];
        $this->assertEquals(
            true,
            $this->query->setOrderArguments($input)
        );
        $this->assertEquals(
            $output,
            $this->query->getOrderArguments()
        );
    }

    public function testSetOrderArgumentsTooManyColumns(): void
    {
        $input = [['nfc', 'asc'], ['nfc', 'asc'], ['nfc', 'asc']];
        $output = array();
        $this->assertEquals(
            false,
            $this->query->setOrderArguments($input)
        );
        $this->assertEquals(
            $output,
            $this->query->getOrderArguments()
        );
    }
}
