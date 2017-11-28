<?php

/**
 * Created by PhpStorm.
 * User: sten
 */

namespace Excel\Exporter;

/**
 * Class AbstractExporter
 * @package Excel\Exporter
 */
abstract class AbstractExporter
{
    /**
     * Generate file with given data
     * @param $data array
     * @throws \Exception
     * @return true
     */
    abstract public function generateFile($data);

    /**
     * Send headers
     * @return mixed
     */
    abstract public function sendFileHeaders();

}