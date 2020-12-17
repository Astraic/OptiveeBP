<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__,4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,4) . '/app/entity/database/Feed.php');
require_once(dirname(__FILE__,4) . '/app/entity/model/Feed.php');

/**
 * Feed database class tests
 * @author Stephan de Jongh
 */

class FeedTest extends TestCase {

    private $database;
    private $mockSelect;
    private $mockUpdate;
    private $input;
    private $output;

    function setUp() : void {
        $this->mockSelect = $this->createMock('app\framework\database\QueryBuilder');
        $this->mockSelect->expects($this->any())->method('getSql')->will($this
            ->returnValue('SELECT * FROM Feed WHERE id = :id'));
        $this->mockUpdate = $this->createMock('app\framework\database\QueryBuilderParent');
        $this->mockUpdate->expects($this->any())->method('getSql')->will($this
            ->returnValue('UPDATE Feed SET name = :nameUpdate AND id = :id WHERE id = :id'));
        $this->database = new \app\entity\database\Feed();
        $this->database->assignStatement($this->mockSelect);
        $this->database->assignStatement($this->mockUpdate);
        
        $this->input = new \app\entity\model\Feed();
        $this->input->setId(1);

        $this->output = new \app\entity\model\Feed();
        $this->output->setId(1);
        $this->output->setName("Vitamix Deluxe");
    }
    
    function testSelect() : void {
        $result = $this->database->select($this->input);
        $this->assertEquals('00000', $result[0]);
        $this->assertEquals(array(array($this->output)), $result[1]);
    }

    function testInsert() : void {
        $result = $this->database->insert($this->input);
        $this->assertEquals('2', $result[0]);
    }

    function testUpdate() : void {  
        $result = $this->database->update($this->output, $this->input);
        $this->assertEquals('0', $result[0]);
    }
}
?>