<?php

namespace App\Queries;

use App\Family;

class FamiliesWithActiveChildren extends QueryObject
{
    /**
     * Execute the query
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return Family::has('services')->has('children')->count();
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Quante famiglie che usufruiscono di servizi area Famiglia HANNO bambini iscritti a servizi bambino?';
    }
}
