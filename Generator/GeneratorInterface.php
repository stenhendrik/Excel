<?php

/**
 * Created by PhpStorm.
 * User: sten
 */

namespace Excel\Generator;

/**
 * Interface GeneratorInterface
 * @package Excel\Generator
 */
interface GeneratorInterface
{
    /**
     * Generate the excel package
     * @param $fileName - reference to the file name
     * @return void
     */
    public function saveFile($fileName);

    /**
     * Add data to excel.
     * @param array $rowData
     * Supports array format, e.g format:
     * 0 => [ 'A' => 'row1 col1', .... 'Z' => 'row1 col26' ],
     * 1 => [], 2 => [], 3 => [], .............. N-1 => [],
     * N => [ 'A' => 'rowN col1', .... 'Z' => 'rowN col26' ]
     * @return void
     */
    public function addData($rowData);

    /**
     * Add array rows to sheet
     * Reference to Sheet1 XML
     * @return string
     */
    public function getSheet();

    /**
     * Reference to Sheet XML stylesheet
     * @return string
     */
    public function getStyleSheet();

    /**
     * Reference to .rels XML
     * @return string
     */
    public function getRels();

    /**
     * Reference to Workbook XML
     * @return string
     */
    public function getWorkBook();

    /**
     * Reference to Content_Types
     * @return string
     */
    public function getContentType();

    /**
     * Reference to Workbook xml rels
     * @return string
     */
    public function getWorkbookRels();
}
