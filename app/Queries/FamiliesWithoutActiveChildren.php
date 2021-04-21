<?php

namespace App\Queries;

use App\Family;

class FamiliesWithoutActiveChildren extends QueryObject
{
    /**
     * Execute the query
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return Family::has('services')->doesntHave('children')->count();
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Quante famiglie che usufruiscono di servizi area Famiglia NON HANNO bambini iscritti a servizi bambino?';
    }
}
