<?php

/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 8/4/2015
 * Time: 12:24 PM
 */
namespace AppBundle\DocumentWorker;

use AppBundle\Interfaces\DocumentWorkerInterface;
use \PHPExcel;
use \PHPExcel_IOFactory;
use AppBundle\Model\Constants;

class ExcelWorker implements DocumentWorkerInterface
{
    /**
     * @param array $config
     */
    public function __construct(array $config = null)
    {

    }

    /**
     * Creates an Excel document and fills the first row with data
     *
     * @param $filename
     * @param array $info
     *
     * @return PHPExcel
     */
    public function createDocument($filename, array $info = null)
    {
        $phpExcel = new PHPExcel();
        $phpExcel->getProperties()->setCreator(($info['creator']) ? $info['creator'] : Constants::EXCEL_CREATOR)
            ->setLastModifiedBy(($info['creator']) ? $info['creator'] : Constants::EXCEL_CREATOR)
            ->setTitle(($info['title']) ? $info['title'] : Constants::EXCEL_TITLE)
            ->setSubject(($info['subject']) ? $info['subject'] : Constants::EXCEL_SUBJECT)
            ->setDescription(($info['description']) ? $info['description'] : Constants::EXCEL_DESCRIPTION)
            ->setKeywords(($info['keywords']) ? $info['keywords'] : Constants::EXCEL_KEYWORDS)
            ->setCategory(($info['category']) ? $info['category'] : Constants::EXCEL_CATEGORY);

        $phpExcel->setActiveSheetIndex(0);

        if (is_null($info['columns']) && !is_array($info['columns'])) {
            $phpExcel->getActiveSheet()->setCellValue('A1', Constants::EXCEL_CELL_A1);
            $phpExcel->getActiveSheet()->setCellValue('B1', Constants::EXCEL_CELL_B1);
            $phpExcel->getActiveSheet()->setCellValue('C1', Constants::EXCEL_CELL_C1);
            $phpExcel->getActiveSheet()->setCellValue('D1', Constants::EXCEL_CELL_D1);
            $phpExcel->getActiveSheet()->setCellValue('E1', Constants::EXCEL_CELL_E1);
            $phpExcel->getActiveSheet()->setCellValue('F1', Constants::EXCEL_CELL_F1);
            $phpExcel->getActiveSheet()->setCellValue('G1', Constants::EXCEL_CELL_G1);
            $phpExcel->getActiveSheet()->setCellValue('H1', Constants::EXCEL_CELL_H1);
        }
        else
        {
            $columnCount = 0;
            $letters  = range('A', 'Z');
            foreach ($info['columns'] as $column)
            {
                $phpExcel->getActiveSheet()->setCellValue($letters[$columnCount] . 1, $column);
                $columnCount++;
            }
        }
        return $phpExcel;
    }

    /**
     * Fills an Excel Document with the data from each book in a book array
     *
     * @param array $info
     * @param PHPExcel $file
     * @param string $filename
     * @param $path
     *
     * @return null
     */
    public function fillDocument(array $info, $file, $filename, $path)
    {
        $i = 2;
        foreach ($info as $book) {
            $file->getActiveSheet()->setCellValue('A' . $i, $book->getIsbn10());
            $file->getActiveSheet()->setCellValue('B' . $i, $book->getIsbn13());
            $file->getActiveSheet()->setCellValue('C' . $i, $book->getTitle());
            $file->getActiveSheet()->setCellValue('D' . $i, $book->getAuthors());
            $file->getActiveSheet()->setCellValue('E' . $i, $book->getPublisher());
            $file->getActiveSheet()->setCellValue('F' . $i, $book->getDescription());
            $file->getActiveSheet()->setCellValue('G' . $i, $book->getPageCount());
            $file->getActiveSheet()->setCellValue('H' . $i, $book->getImageLink());
            $i++;
        }
        $file->setActiveSheetIndex(0);

        $writer = PHPExcel_IOFactory::createWriter($file, 'Excel2007');
        $file = $path . $filename;
        $writer->save($file);
    }

    /**
     * Gets the ISBNS from an Excel document
     *
     * @param $file
     * @param $path
     * @param $filename
     *
     * @return array
     */
    public function getISBNSFromDocument($file, $path, $filename)
    {
        $file['file']->move($path, $filename);
        $excel = PHPExcel_IOFactory::load($path . $filename);
        $sheet = $excel->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        $isbns = [];

        for ($row = 1; $row <= $highestRow; ++$row) {
            $isbns[] = $sheet->getCellByColumnAndRow(0, $row)->getValue();
        }

        return $isbns;
    }
}