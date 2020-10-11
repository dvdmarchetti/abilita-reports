<?php

namespace App\Queries;

use App\Child;

class ServiceCountPerChildren extends QueryObject
{
    /**
     * Execute the query:
     *  14) Conteggio di bambini per numero di servizi
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return Child::withCount('services')
            ->get()
            ->countBy('services_count');
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return '14) Conteggio di bambini per numero di servizi';
    }
}