<?php
/**
 *
 * @Author: Shaharia Azam
 *
 */

use Phpie\Autoload\Autoload;

$pathLibrary = realpath(dirname(dirname(__DIR__)));
$pathTests = realpath(dirname(__DIR__));

include $pathLibrary . '/Phpie/Autoload/Autoload.php';

Autoload::register(
    array(
        'Phpie' => $pathLibrary,
        'Tests' => $pathTests
    )
);