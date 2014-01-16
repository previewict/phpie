<?php
include_once '../Bootstrap.php';
/**
 * Cli Component Tests to work with PHP command line
 *
 * @Author Shaharia Azam
 * @URI http://www.shahariaazam.com
 */

use Phpie\Cli\Cli;

class CliTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->Cli = new Cli();
    }
    public function testColoredString()
    {
        $this->assertEquals('[0;31mtest[0m', Cli::coloredString('red', array('test')));
    }
}