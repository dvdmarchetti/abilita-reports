<?php

namespace App\Imports;

use App\Imports\Sheets\ChildrenImport;
use App\Imports\Sheets\ServicesImport;

class ChildServiceImport extends ExcelWorksheetImport
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
            // 'ANAGRAFICA-F' => new FamiliesImport($this),
            'SERVIZIO' => new ServicesImport($this),
        ];
    }
}
