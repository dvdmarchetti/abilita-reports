<?php

namespace App\Queries;

use App\Child;

class ChildrenPerNationality extends QueryObject
{
    /**
     * Execute the query:
     *  5) Quanti per nazionalità? Italiana o Straniera
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return Child::groupBy('nationality')
            ->selectRaw('nationality, count(*) as total')
            ->get()
            ->pluck('total', 'nationality')
            ->sortKeys();
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Quanti bambini per ciascuna nazionalità?';
    }
}
