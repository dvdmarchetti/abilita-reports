<?php

namespace App\Queries;

use App\Service;

class ChildrenPerService extends QueryObject
{
    /**
     * Execute the query:
     *  2) Conteggio di bambini per servizio
     *
     * @return \Illuminate\Support\Collection
     */
    public function __invoke()
    {
        return Service::withCount('children')
            ->pluck('children_count', 'id');
    }
}