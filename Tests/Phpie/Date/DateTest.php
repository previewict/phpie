<?php
include_once('../Bootstrap.php');

use Phpie\Date;

class DateTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->Date = new Phpie\Date\Date();
    }

    public function testWithoutArgument()
    {
        $this->assertEquals(NULL, $this->Date->test());
    }
}
 