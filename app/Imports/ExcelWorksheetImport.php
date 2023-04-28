<?php

namespace App\Imports;

use App\Service;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

abstract class ExcelWorksheetImport implements WithMultipleSheets
{
    use Importable;

    /**
     * Hold the current service instance.
     *
     * @var \App\Service
     */
    protected Service $service;

    /**
     * Set the current service that is importing the child
     *
     * @param [type] $service
     * @return self
     */
    public function for($service)
    {
        $this->service = Service::firstOrCreate([
            'id' => $service
        ]);

        return $this;
    }

    abstract public function sheets(): array;

    /**
     * Return the service instance.
     *
     * @return \App\Service
     */
    public function getService()
    {
        return $this->service;
    }
}
