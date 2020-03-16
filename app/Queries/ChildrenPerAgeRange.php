<?php

namespace App\Queries;

use App\Child;
use Illuminate\Support\Facades\DB;

class ChildrenPerAgeRange extends QueryObject
{
    /**
     * Execute the query:
     *  3) Quanti bambini di che età? Da 0 mesi ai 12 anni
     *
     * @return \Illuminate\Support\Collection
     */
    public function __invoke()
    {
        return Child::query()
            ->select(DB::raw('TIMESTAMPDIFF(YEAR, CONCAT(birth_date, DATE_FORMAT(CURDATE(), \'-%m-%d\')), CURDATE()) AS age, COUNT(*) as bambini'))
            ->groupBy('age')
            ->get()
            ->pluck('bambini', 'age');
    }
}
