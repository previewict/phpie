<?php

require "vendor/autoload.php";

$data = new \Phpie\Date\Date();
var_dump($data::timezoneList());

die();