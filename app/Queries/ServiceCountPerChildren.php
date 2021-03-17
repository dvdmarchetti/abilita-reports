<?php

namespace App\Queries;

use App\Child;

class ServiceCountPerChildren extends QueryObject
{
    /**
     * Execute the query
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        $childrenPerService = Child::withCount('services')
            ->get()
            ->countBy('services_count')
            ->sortKeys();

        foreach ($childrenPerService as $i => $count) {
            for ($j = 1; $j < $i; $j++) {
                $childrenPerService->put($j, $childrenPerService->get($j) + $count);
            }
        }

        return $childrenPerService;
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Conteggio di bambini per numero di servizi';
    }
}
