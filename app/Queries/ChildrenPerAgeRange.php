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
    public function results()
    {
        return Child::query()
            ->selectRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age, COUNT(*) as bambini')
            ->groupBy('age')
            ->get()
            ->pluck('bambini', 'age');
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return '4) Quanti bambini di che età? Da 0 mesi ai 12 anni';
    }
}
