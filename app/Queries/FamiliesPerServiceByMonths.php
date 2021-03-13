<?php

namespace App\Queries;

use App\Relations\FamilyService;

class FamiliesPerServiceByMonths extends QueryObject
{
    static protected $template = 'queries.per-service-by-months';

    /**
     * Execute the query:
     *  10) Quanti bambini per quanti mesi hanno frequentato il servizio nel 2019? Da 1 a 12 mesi
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return FamilyService::query()
            ->selectRaw('service_id, attendance_months, count(*) as famiglie')
            ->groupBy(['service_id', 'attendance_months'])
            ->get()
            ->groupBy('service_id')->map->pluck('famiglie', 'attendance_months');
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Quanti bambini per quanti mesi hanno frequentato il servizio nel '. config('bs.year') .'? Da 1 a 12 mesi';
    }
}
