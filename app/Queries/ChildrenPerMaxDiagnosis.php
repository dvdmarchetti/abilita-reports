<?php

namespace App\Queries;

use App\Relations\ChildService;

class ChildrenPerMaxDiagnosis extends QueryObject
{
    /**
     * Execute the query:
     *  13) Quanti servizi frequenta ciascun bambino
     *
     * @return \Illuminate\Support\Collection
     */
    public function __invoke()
    {
        return ChildService::query()
            ->selectRaw('diagnosis_count, count(distinct child_id) as bambini')
            ->groupBy('diagnosis_count')
            ->get()
            ->pluck('bambini', 'diagnosis_count');
    }
}
