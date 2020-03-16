<?php

namespace App\Queries;

use App\Child;

class ChildrenTotal extends QueryObject
{
    /**
     * Execute the query:
     *  1) Totale dei bambini iscritti nel 2019
     *
     * @return \Illuminate\Support\Collection
     */
    public function __invoke()
    {
        return Child::count();
    }
}