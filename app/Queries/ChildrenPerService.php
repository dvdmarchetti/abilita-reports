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
    public function results()
    {
        return Service::withCount('children')
            ->pluck('children_count', 'id');
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return '2) Conteggio di bambini per servizio';
    }
}