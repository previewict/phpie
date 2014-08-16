<?php
require_once '../../../../vendor/autoload.php';

class UrlTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    public function tearDown()
    {
    }

    public function testGetSubdomainWithoutAnyParameter()
    {
        $url = new Phpie\Component\Url\Url();
        $this->assertFalse($url->getSubdomain());
    }

    public function testGetSubdomainWithParam()
    {
        $param = 'test.com';
        $url = new Phpie\Component\Url\Url();
        $this->assertEquals($param, $url->getSubdomain($param));
    }
}