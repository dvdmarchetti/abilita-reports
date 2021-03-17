<?php

namespace App\Queries;

use App\Relations\ChildService;

class ChildrenPerSourceChannel extends QueryObject
{
    /**
     * Execute the query
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return ChildService::query()
            ->selectRaw('source, count(*) as bambini')
            ->groupBy('source')
            ->get()
            ->pluck('bambini', 'source');
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Quanti bambini per ogni fonte di invio?';
    }
}
