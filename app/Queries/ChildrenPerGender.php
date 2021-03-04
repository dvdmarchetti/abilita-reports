<?php

namespace App\Queries;

use App\Child;

class ChildrenPerGender extends QueryObject
{
    /**
     * Execute the query:
     *  3) Quanti maschi/quante femmine
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return Child::groupBy('gender')
            ->selectRaw('gender, count(*) as bambini')
            ->get()
            ->pluck('bambini', 'gender');
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return '3) Quanti maschi/quante femmine?';
    }
}
