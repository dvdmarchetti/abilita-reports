<?php

namespace App\Imports\Sheets;

use Illuminate\Support\Collection;

class NullImport extends CommonImport
{
    /**
     * Set the parent Multisheet importer
     *
     * @param \Maatwebsite\Excel\Concerns\BilancioSocialeImport $spreadsheet
     * @return void
     */
    public function __construct($spreadsheet)
    {
        parent::__construct($spreadsheet, 'ANAGRAFICA-B');
    }

    public function collection(Collection $rows)
    {
        return [];
    }

    /**
     * Define column validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Create a new child or attach a new service to him.
     *
     * @param \Illuminate\Support\Collection $row
     * @return void
     */
    protected function store($row)
    {
        //
    }
}
