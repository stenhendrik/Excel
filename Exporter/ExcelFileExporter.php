<?php

/**
 * Created by PhpStorm.
 * User: sten
 */
namespace Excel\Exporter;

use Excel\Config;
use Excel\Generator\ExcelGenerator;
use Excel\Exporter\AbstractExporter;

include 'Generator/ExcelGenerator.php';
include 'AbstractExporter.php';
include 'Config.php';

/**
 * Class ExcelFileExporter
 * @package Excel\Exporter
 */
class ExcelFileExporter extends AbstractExporter
{
    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var Config
     */
    protected $config;

    /**
     * ExcelFileExporter constructor.
     * @param Config $config
     */
    public function __construct(Config $config )
    {
        $this->fileName = sprintf('Excel_%s%s', time(), '.xlsx');
        $this->config = $config;
    }

    /**
     * {@inheritdoc }
     */
    final public function generateFile($data)
    {
        if(!is_array($data)) {
            throw new \Exception('Data should be given in array form');
        }
        $excelFile = new ExcelGenerator($this->config->getPath());
        $excelFile->addData($data);
        $excelFile->saveFile($this->fileName);

        return true;
    }

    /**
     * {@inheritdoc }
     */
    final public function sendFileHeaders()
    {
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
        header('Content-Disposition: attachment: filename='.$this->fileName);
        header('Pragma: public');
        header('Cache-Control: maxage=1');
        return;
    }
    public function unlink()
    {
        unlink(sprintf('%s%s',$this->config->getPath(),$this->fileName));
    }
}