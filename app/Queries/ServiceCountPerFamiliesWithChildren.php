<?php

namespace App\Queries;

use App\Child;
use App\Family;

class ServiceCountPerFamiliesWithChildren extends QueryObject
{
    /**
     * Execute the query
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        $familiesWithServices = Family::withCount('services')
            ->has('services')
            ->pluck('services_count', 'id');

        $familiesPerServiceCount = Child::withCount('services')
            ->get()
            ->groupBy('family_id')
            ->map->sum('services_count')
            ->zip($familiesWithServices)
            ->map->sum()
            ->countBy()
            ->sortKeys();

        foreach ($familiesPerServiceCount as $i => $count) {
            for ($j = 1; $j < $i; $j++) {
                $familiesPerServiceCount->put($j, $familiesPerServiceCount->get($j) + $count);
            }
        }

        return $familiesPerServiceCount;
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Conteggio di famiglie per numero di servizi (include servizi FAM)';
    }
}
