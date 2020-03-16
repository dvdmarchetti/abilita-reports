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
    public function __invoke()
    {
        return Child::groupBy('gender')
            ->selectRaw('gender, count(*) as children_count')
            ->get();
    }
}
