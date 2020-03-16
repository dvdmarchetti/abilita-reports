<?php

namespace App\Imports;

use App\Service;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BilancioSocialeImport implements WithMultipleSheets
{
    use Importable;

    /**
     * Hold the current service instance.
     *
     * @var \App\Service
     */
    protected Service $service;

    /**
     * Set the current service that is ipmorting the child
     *
     * @param [type] $service
     * @return void
     */
    public function for($service)
    {
        $this->service = Service::firstOrCreate([
            'id' => $service
        ]);

        return $this;
    }

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
            // 'ANAGRAFICA-F' => new FamiliesImport($this),
        ];
    }

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