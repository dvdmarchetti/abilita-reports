<?php

namespace App\Queries;

use App\Service;

class FamiliesPerService extends QueryObject
{
    /**
     * Execute the query
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return Service::forFamilies()
            ->withCount('families')
            ->pluck('families_count', 'id');
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Conteggio di famiglie per servizio';
    }
}
