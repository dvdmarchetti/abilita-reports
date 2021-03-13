<?php

namespace App\Imports;

use App\Imports\Sheets\ChildrenImport;
use App\Imports\Sheets\ServicesImport;

class ChildWorksheetImport extends ExcelWorksheetImport
{
    /**
     * Process different worksheets with different importers.
     *
     * @return array
     */
    public function sheets(): array
    {
        return [
            'ANAGRAFICA-B' => new ChildrenImport($this),
            'SERVIZIO' => new ServicesImport($this),
        ];
    }
}
