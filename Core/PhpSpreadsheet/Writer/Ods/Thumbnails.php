<?php

namespace Core\PhpSpreadsheet\Writer\Ods;

use Core\PhpSpreadsheet\Spreadsheet;

class Thumbnails extends WriterPart
{
    /**
     * Write Thumbnails/thumbnail.png to PNG format.
     *
     * @param Spreadsheet $spreadsheet
     *
     * @return string XML Output
     */
    public function writeThumbnail(?Spreadsheet $spreadsheet = null)
    {
        return '';
    }
}
