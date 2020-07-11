<?php

namespace App\Queries;

use App\Relations\ChildService;

class ChildrenPerEndReason extends QueryObject
{
    /**
     * Execute the query:
     *  11) Quanti bambini per ogni motivo del temine della presa in carico
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return ChildService::query()
            ->selectRaw('end_reason, count(distinct child_id) as bambini')
            ->whereNotNull('end_reason')
            ->where('end_reason', '<>', '')
            ->groupBy('end_reason')
            ->get()
            ->pluck('bambini', 'end_reason');
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return '11) Quanti bambini per ogni motivo del temine della presa in carico';
    }
}