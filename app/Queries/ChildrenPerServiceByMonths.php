<?php

namespace App\Queries;

use App\Relations\ChildService;

class ChildrenPerServiceByMonths extends QueryObject
{
    static protected $template = 'queries.children-per-service-by-months';

    /**
     * Execute the query:
     *  10) Quanti bambini per quanti mesi hanno frequentato il servizio nel 2019? Da 1 a 12 mesi
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return ChildService::query()
            ->selectRaw('service_id, attendance_months, count(*) as bambini')
            ->groupBy(['service_id', 'attendance_months'])
            ->get()
            ->groupBy('service_id')->map->pluck('bambini', 'attendance_months');
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
