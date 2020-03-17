<?php

namespace App\Queries;

use App\Relations\ChildService;

class ChildrenPerDiagnosisArea extends QueryObject
{
    /**
     * Execute the query:
     *  7) Quanti bambini per (area di) diagnosi
     *
     * @return \Illuminate\Support\Collection
     */
    public function __invoke()
    {
        return ChildService::query()
            ->selectRaw('diagnosis_area, count(*) as bambini')
            // ->whereNotNull('diagnosis_area')
            // ->where('diagnosis_area', '<>', '')
            ->groupBy('diagnosis_area')
            ->get()
            ->pluck('bambini', 'diagnosis_area');
    }
}
