<?php
include_once('../../Bootstrap.php');
include_once('config.php');

use Phpie\Courier\Fedex\Fedex;
use Phpie\Courier\Fedex\Track;


class TrackTest extends PHPUnit_Framework_TestCase
{

    public $track;

    protected $authKey;
    protected $authPassword;
    protected $authAccountNumber;
    protected $authMeterNumber;

    public function setUp()
    {
        $this->authKey = authKey;
        $this->authPassword = authPassword;
        $this->authAccountNumber = authAccountNumber;
        $this->authMeterNumber = authMeterNumber;
    }

    public function testTrack()
    {
        $track = new Track($this->authKey, $this->authPassword, $this->authAccountNumber, $this->authMeterNumber);
        $track->track(trackingNumber);
        var_dump($track->statusDescription);
        die();
    }

    public function tearDown()
    {

    }
}
