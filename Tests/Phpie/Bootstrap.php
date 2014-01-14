<?php
/**
 *
 * @Author: Shaharia Azam
 *
 */

use Phpie\Autoload\Autoload;

$path = realpath(dirname(__DIR__));

include $path . '/Phpie/Autoload/Autoload.php';

Autoload::register(
    array(
        'Phpie' => $path,
        'Tests' => $path
    )
);