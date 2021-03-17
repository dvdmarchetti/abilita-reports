<?php

namespace App\Queries;

use App\Service;

class ChildrenPerService extends QueryObject
{
    /**
     * Execute the query
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return Service::forChildren()
            ->withCount('children')
            ->pluck('children_count', 'id');
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Conteggio di bambini per servizio';
    }
}
