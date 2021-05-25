<?php

namespace App\Queries;

use App\Child;
use App\Relations\ChildService;
use Carbon\Carbon;

class ChildrenPerYearsByService extends QueryObject
{
    static protected $template = 'queries.per-service-by-years';

    /**
     * Execute the query
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        $current_timestamp = Carbon::createMidnightDate(config('bs.year'), 1, 1);

        return ChildService::query()
            ->selectRaw('service_id, TIMESTAMPDIFF(YEAR, first_appearance, CASE WHEN end_of_charge IS NULL THEN "' . $current_timestamp . '" ELSE end_of_charge END) + 1 AS attendance_years, COUNT(*) AS children_count')
            ->groupBy(['service_id', 'attendance_years'])
            ->get()
            ->groupBy('service_id')->map->pluck('children_count', 'attendance_years');
    }

    /**
     * Custom view renderer
     *
     * @return string
     */
    public function view()
    {
        $results = $this->results();
        $column_count = $results->map->flip()->flatten()->max();

        return view(static::$template ?? 'queries.plain', compact('results', 'column_count'));
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Quanti bambini per quanti anni hanno frequentato il servizio nel '. config('bs.year') .'?';
    }
}
