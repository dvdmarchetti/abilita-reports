<?php

namespace App\Queries;

use App\Child;

class ChildrenActive extends QueryObject
{
    /**
     * Execute the query:
     *  1) Totale dei bambini iscritti nel 2019
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return Child::active()->count();
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Totale dei bambini attivi al 31/12/'.config('bs.year');
    }
}
