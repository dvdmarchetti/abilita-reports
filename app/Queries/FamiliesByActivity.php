<?php

namespace App\Queries;

use App\Family;
use App\Relations\FamilyService;

class FamiliesByActivity extends QueryObject
{
    /**
     * Execute the query
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        $activities = [];

        FamilyService::query()
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
            ->each->each(function ($activity) use (&$activities) {
                if (! array_key_exists($activity, $activities)) {
                    $activities[$activity] = 0;
                }

                $activities[$activity] += 1;
            });

        return collect($activities);
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Famiglie divise per attività in servizio FAM';
    }
}
