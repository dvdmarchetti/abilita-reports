<?php

namespace App\Imports;

use App\Imports\Sheets\FamiliesImport;
use App\Imports\Sheets\ServicesImport;

class FamilyServiceImport extends ExcelWorksheetImport
{
    /**
     * Process different worksheets with different importers.
     *
     * @return array
     */
    public function sheets(): array
    {
        return [
            // 'ANAGRAFICA-B' => new ChildrenImport($this),
            'ANAGRAFICA-F' => new FamiliesImport($this),
            'SERVIZIO' => new ServicesImport($this),
        ];
    }
}
