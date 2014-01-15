<?php
include_once('../Bootstrap.php');

use Phpie\Date\Date;

class DateTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->Date = new Date();
    }

    public function testClassLoadWithoutTimezone()
    {
        $this->Date = new Date();
    }

    public function testClassLoadWithTimezone()
    {
        $this->Date = new Date('Australia/AoCT');
        $this->assertEquals('Asia/Dhaka',$this->Date->getTimezone());
    }

    public function testClassLoadWithInvalidTimezone()
    {
        $this->Date = new Date('Invalid Timezone');
        $this->assertEquals('Asia/Dhaka',$this->Date->getTimezone());
    }

    public function testClassLoadWithValidTimezone()
    {
        $this->Date = new Date('Australia/Sydney');
        $this->assertEquals('Australia/Sydney',$this->Date->getTimezone());
    }

    public function testSetTimezoneWithValidTimezone()
    {
        $this->Date->setTimezone('Australia/Sydney');
        $this->assertEquals('Australia/Sydney', $this->Date->getTimezone());
    }

    public function testSetTimezoneWithInvalidTimezone()
    {
        $this->assertEmpty($this->Date->setTimezone('Invalid Timezone'));
    }

    public function testGetTimezoneList()
    {
        $this->assertNotEmpty($this->Date->timezoneList());
    }



    public function testTimezoneIdValidationForValidTimezone()
    {
        $this->assertTrue(true, $this->Date->isValidTimezone('Asia/Dhaka'));
    }

    public function testTimezoneIdValidationForInvalidTimezone()
    {
        $this->assertFalse(false, $this->Date->isValidTimezone('Invalid Timezone'));
    }

    public function testSetFormat()
    {
        $this->Date->setFormat('m/d/y');
        $this->assertEquals('m/d/y', $this->Date->getFormat());
    }

    public function testSetFormatForPredefinedFormatConstant()
    {
        foreach(Date::$formatConst as $key => $value){
            $this->Date->setFormat(Date::$formatConst[$key]);
            $this->assertEquals($value, $this->Date->getFormat());
        }
    }
}
 