<?php
/**
 * Created by PhpStorm.
 * User: sten
 */
namespace Excel;
use Excel\Exporter\ExcelFileExporter;

include 'Exporter/ExcelFileExporter.php';

$array = [];
$array[] = ['A' => 'A', 'B' => 'B'];

/** @var Config $config */
$config = new Config();

/** @var ExcelFileExporter $excel */
$excel = new ExcelFileExporter($config);
$file = $excel->generateFile($array);

if($file) {
    return $excel->sendFileHeaders();
}
