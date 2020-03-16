<?php

namespace App\Queries;

use App\Service;
use Illuminate\Http\Request;

class ChildrenPerService extends QueryObject
{
    /**
     * Execute the query:
     *  1) Quanti bambini per servizi
     *
     * @return \Illuminate\Support\Collection
     */
    public function __invoke(Request $request)
    {
        return Service::withCount('children')
            // ->get();
            ->pluck('children_count', 'id');
    }
}