<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once(dirname(__FILE__, 4) . '/app/framework/database/Database.php');
require_once(dirname(__FILE__, 4) . '/tests/Reflection.php');

final class DatabaseTest extends TestCase
{

    public function setUp() : void{
        $this->reflection = ReflectionExecuter::getPrivateProperty('app\framework\database\Database', 'instance');
    }

    public function testGetConnection(): void
    {
        $instance = \app\framework\database\Database::getConnection();
        $this->assertNotEquals(
            null,
            $this->reflection
        );

        $this->assertNotEquals(
            null,
            $instance
        );

        $this->assertNotEquals(
            $instance,
            $this->reflection
        );
    }


}
