<?php

namespace App\Queries;

use App\Relations\FamilyService;

class FamiliesWithMoreThanOneActivity extends QueryObject
{
    /**
     * Execute the query
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        [$above, $below] = FamilyService::query()
            ->where('service_id', 'FAM')
            ->get()
            ->groupBy('family_id')
            ->map(function ($familyServices) {
                return $familyServices->map(function ($service) {
                    return [
                        $service->activity_1,
                        $service->activity_2,
                        $service->activity_3,
                        $service->activity_4,
                    ];
                })->collapse()->unique()->filter()->values();
            })
            ->map->count()
            ->partition(function ($value) {
                return $value > 1;
            });

        return collect([
            'SINGOLA ATTIVITÀ' => $below->count(),
            'ALMENO DUE ATTIVITÀ' => $above->count(),
        ]);
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Famiglie con più di 1 attività in servizio FAM?';
    }
}
