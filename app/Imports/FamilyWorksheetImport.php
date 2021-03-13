<?php

namespace App\Imports;

use App\Imports\Sheets\FamilyServicesImport;
use App\Imports\Sheets\NullImport;

class FamilyWorksheetImport extends ExcelWorksheetImport
{
    /**
     * Process different worksheets with different importers.
     *
     * @return array
     */
    public function sheets(): array
    {
        return [
            'ANAGRAFICA-B' => new NullImport($this),
            'ANAGRAFICA-F' => new NullImport($this),
            'SERVIZIO' => new FamilyServicesImport($this),
        ];
    }
}
