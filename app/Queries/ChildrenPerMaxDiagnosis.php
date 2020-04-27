<?php

namespace App\Queries;

use App\Relations\ChildService;

class ChildrenPerMaxDiagnosis extends QueryObject
{
    /**
     * Execute the query:
     *  8) Quanti bambini con più diagnosi?
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return ChildService::query()
            ->selectRaw('count(distinct child_id) as bambini, max(diagnosis_count) as diagnosis')
            ->groupBy('child_id')
            ->get()
            ->countBy(function ($row) {
                return $row->diagnosis;
            })
            ->sortKeys();
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return '8) Quanti bambini con più diagnosi?';
    }
}
