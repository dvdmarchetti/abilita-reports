<?php

namespace App\Queries;

use Illuminate\Support\Facades\DB;

class ChildrenPerEndReason extends QueryObject
{
    /**
     * Execute the query:
     *  10) Quanti bambini per ogni motivo del temine della presa in carico
     *
     * @return \Illuminate\Support\Collection
     */
    public function __invoke()
    {
        return DB::table('child_service')
            ->select(DB::raw('end_reason, count(distinct child_id) as bambini'))
            ->whereNotNull('end_reason')
            ->where('end_reason', '<>', '')
            ->groupBy('end_reason')
            ->get()
            ->pluck('bambini', 'end_reason');
    }
}
