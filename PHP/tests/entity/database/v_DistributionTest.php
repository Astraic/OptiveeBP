<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__,4) . '/app/framework/exception/ModelNullException.php');
require_once(dirname(__FILE__,4) . '/app/entity/database/v_Distribution.php');
require_once(dirname(__FILE__,4) . '/app/entity/model/v_Distribution.php');

/**
 * v_Distribution database class tests
 * @author Stephan de Jongh
 */

class v_DistributionTest extends TestCase {

    private $database;
    private $mockSelect;
    private $input;
    private $output;

    function setUp() : void {
        $this->mockSelect = $this->createMock('app\framework\database\QueryBuilder');
        $this->mockSelect->expects($this->any())->method('getSql')->will($this
            ->returnValue('SELECT * FROM v_Distribution WHERE nfc = :nfc'));
        $this->database = new \app\entity\database\v_Distribution();
        $this->database->assignStatement($this->mockSelect);
        
        $this->input = new \app\entity\model\v_Distribution();
        $this->input->setNfc("DE12");

        $this->output = new \app\entity\model\v_Distribution();
        $this->output->setNfc("DE12");
        $this->output->setFeedid(5);
        $this->output->setPortion(0.700);
        $this->output->setAssigned(4.200);
    }
    
    function testSelect() : void {
        $result = $this->database->select($this->input);
        $this->assertEquals('00000', $result[0]);
        $this->assertEquals(array(array($this->output)), $result[1]);
    }
}
?>