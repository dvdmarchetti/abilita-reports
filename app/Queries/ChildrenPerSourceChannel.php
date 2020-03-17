<?php

namespace App\Queries;

use App\Relations\ChildService;

class ChildrenPerSourceChannel extends QueryObject
{
    /**
     * Execute the query:
     *  12) Quanti bambini per ogni fonte di invio
     *
     * @return \Illuminate\Support\Collection
     */
    public function __invoke()
    {
        return ChildService::query()
            ->selectRaw('source, count(*) as bambini')
            ->groupBy('source')
            ->get()
            ->pluck('bambini', 'source');
    }
}
