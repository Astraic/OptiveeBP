<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__,4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,4) . '/app/entity/database/Fat.php');
require_once(dirname(__FILE__,4) . '/app/entity/model/Fat.php');

/**
 * Fat database class tests
 * @author Stephan de Jongh
 */

class FatTest extends TestCase {

    private $database;
    private $mockSelect;
    private $mockUpdate;
    private $input;

    function setUp() : void {
        $this->mockSelect = $this->createMock('app\framework\database\QueryBuilder');
        $this->mockSelect->expects($this->any())->method('getSql')->will($this
            ->returnValue('SELECT * FROM Fat WHERE name = :name'));
        $this->mockUpdate = $this->createMock('app\framework\database\QueryBuilderParent');
        $this->mockUpdate->expects($this->any())->method('getSql')->will($this
            ->returnValue('UPDATE Fat SET name = :nameUpdate WHERE name = :name'));
        $this->database = new \app\entity\database\Fat();
        $this->database->assignStatement($this->mockSelect);
        $this->database->assignStatement($this->mockUpdate);
        
        $this->input = new \app\entity\model\Fat();
        $this->input->setName("3");
    }
    
    function testSelect() : void {
        $result = $this->database->select($this->input);
        $this->assertEquals('00000', $result[0]);
        $this->assertEquals(array(array($this->input)), $result[1]);
    }

    function testInsert() : void {
        $result = $this->database->insert($this->input);
        $this->assertEquals('2', $result[0]);
    }

    function testUpdate() : void {  
        $result = $this->database->update($this->input, $this->input);
        $this->assertEquals('0', $result[0]);
    }
}
?>