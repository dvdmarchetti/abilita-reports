<?php

namespace App\Queries;

use App\Child;

class ChildrenPerAgeRange extends QueryObject
{
    /**
     * Execute the query
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return Child::query()
            ->selectRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age, COUNT(*) as bambini')
            ->groupBy('age')
            ->orderBy('age')
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
        return 'Quanti bambini di che età? Divisi in fasce di un anno.';
    }
}
