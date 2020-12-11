<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/framework/exception/NullPointerException.php');
require_once(dirname(__FILE__, 4) . '/app/framework/database/Query.php');
require_once(dirname(__FILE__, 4) . '/app/entity/model/Animal.php');
require_once(dirname(__FILE__, 4) . '/app/entity/api/NewAnimal.php');
final class QueryUpdateTest extends TestCase
{
    protected $query;

    public function setUp() : void{
        $this->query = new \app\framework\database\QueryUpdate(new \app\entity\model\Animal(), new \app\entity\api\NewAnimal());
    }

    public function testSetSetArguments(): void
    {
        $good_input = [['country', 'test']];
        $this->assertEquals(
            true,
            $this->query->setSetArguments($good_input)
        );
        $this->assertEquals(
            [['country']],
            $this->query->getSetArguments()
        );
    }

    public function testSetSetArgumentsMultiple(): void
    {
        $good_input = [['country', 'test'], ['serial', 'test']];
        $this->assertEquals(
            true,
            $this->query->setSetArguments($good_input)
        );
        $this->assertEquals(
            [['country'], ['serial']],
            $this->query->getSetArguments()
        );
    }

    public function testSetSetArgumentsBadArguments(): void
    {
        $good_input = [['illigal_column_name'], ['serial']];
        $this->assertEquals(
            false,
            $this->query->setSetArguments($good_input)
        );

        $this->assertEquals(
            array(),
            $this->query->getSetArguments()
        );
    }


}
