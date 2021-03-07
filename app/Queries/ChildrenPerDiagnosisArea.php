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
    public function results()
    {
        return ChildService::query()
            ->selectRaw('diagnosis_area, count(*) as bambini')
            ->groupBy('diagnosis_area')
            ->get()
            ->pluck('bambini', 'diagnosis_area');
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Quanti bambini per area di diagnosi?';
    }
}
