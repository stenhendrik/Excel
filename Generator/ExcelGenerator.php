<?php

/**
 * Created by PhpStorm.
 * User: sten
 */
namespace Excel\Generator;

use Excel\Config;
use Excel\Generator\GeneratorInterface;
include 'GeneratorInterface.php';

/**
 * Class ExcelGenerator
 * @package Excel\Generator
 */
final class ExcelGenerator implements GeneratorInterface
{

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    protected $path;

    /**
     * ExcelGenerator constructor.
     * @param $path
     */
    function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * {@inheritdoc }
     */
    final public function saveFile($fileName)
    {
        /** @var \ZipArchive $zip */
        $zip = new \ZipArchive();
        $zip->open(sprintf('%s%s',$this->path, $fileName), \ZipArchive::CREATE);

        $zip->addEmptyDir('_rels');
        $zip->addFromString('_rels/.rels', $this->getRels());
        $zip->addEmptyDir('xl');
        $zip->addFromString('xl/workbook.xml', $this->getWorkBook());
        $zip->addEmptyDir('xl/worksheets');
        $zip->addFromString('xl/worksheets/sheet1.xml', $this->getSheet());
        $zip->addEmptyDir('xl/_rels');
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->getWorkbookRels());
        $zip->addFromString('[Content_Types].xml', $this->getContentType());

        $zip->close();

        return $fileName;
    }

    /**
     * {@inheritdoc }
     */
    final public function addData($rowData)
    {
        $this->data = array_merge($this->data, $rowData);
    }

    /**
     * {@inheritdoc }
     */
    final public function getSheet()
    {
        $i = 0;
        $rowFields = null;
        foreach ($this->data as $rowNumber => $row) {
            $i++;
            $rowFields .= '<row>';
            foreach ($row as $column => $value) {
                $rowFields .= sprintf(
                    '<c nr="%s" t="inlineStr"><is><t>%s</t></is></c>',
                    ($column . $i),
                    str_replace(['&', '<', '>', '*'], '', $value)
                );
            }
            $rowFields .= '</row>';
        }
        return sprintf(
            '%s%s%s',
            $this->getSheetBeginning(),
            $rowFields,
            $this->getSheetEnding()
        );
    }

    /**
     * @return string
     */
    protected function getSheetBeginning()
    {
        return sprintf('<?xml version="1.0" encoding="utf-8" standalone="yes"?>
            <worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
                <sheetData>'
        );
    }

    /**
     * @return string
     */
    protected function getSheetEnding()
    {
        return sprintf('
                </sheetData>
            </worksheet>'
        );
    }

    /**
     * {@inheritdoc }
     */
    final public function getStyleSheet()
    {
        return '';
    }

    /**
     * {@inheritdoc }
     */
    final public function getRels()
    {
        return sprintf(
            '<?xml version="1.0" encoding="UTF-8"?>
			<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
				<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
			</Relationships>'
        );
    }

    /**
     * {@inheritdoc }
     */
    final public function getWorkBook()
    {
        return sprintf(
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
			    <workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
			        <sheets>
				        <sheet name="Sheet1" sheetId="1" r:id="rId1" />
			        </sheets>
			    </workbook>'
        );
    }

    /**
     * {@inheritdoc }
     */
    public function getContentType()
    {
        return sprintf(
            '<?xml version="1.0" encoding="UTF-8"?>
			<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
				<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
				<Default Extension="xml" ContentType="application/xml"/>
				<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
				<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
			</Types>'
        );
    }

    /**
     * {@inheritdoc }
     */
    final public function getWorkbookRels()
    {
        return sprintf(
            '<?xml version="1.0" encoding="UTF-8"?>
			<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
				<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
			</Relationships>'
        );
    }
}