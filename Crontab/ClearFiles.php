<?php
/**
 * Created by PhpStorm.
 * User: sten
 */

$files = glob('../Files/*.xlsx');
foreach ($files as $file) {
    if(is_file($file)) {
        unlink($file);
    }
}