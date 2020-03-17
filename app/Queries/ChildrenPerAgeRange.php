<?php

namespace App\Queries;

use App\Child;

class ChildrenPerAgeRange extends QueryObject
{
    /**
     * Execute the query:
     *  4) Quanti bambini di che età? Da 0 mesi ai 12 anni
     *
     * @return \Illuminate\Support\Collection
     */
    public function __invoke()
    {
        return Child::query()
            ->selectRaw('TIMESTAMPDIFF(YEAR, CONCAT(birth_date, DATE_FORMAT(CURDATE(), \'-%m-%d\')), CURDATE()) AS age, COUNT(*) as bambini')
            ->groupBy('age')
            ->get()
            ->pluck('bambini', 'age');
    }
}
