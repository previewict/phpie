<?php

use Phpie\Date;

class DateTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->Date = new Phpie\Date\Date();
    }

    public function testWithoutArgument()
    {
        var_dump($this->Date);
    }
}
 