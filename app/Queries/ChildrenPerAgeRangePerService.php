<?php

namespace App\Queries;

use App\Child;
use App\Relations\ChildService;

class ChildrenPerAgeRangePerService extends QueryObject
{
    static protected $template = 'queries.per-service-by-x';

    /**
     * Execute the query
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return ChildService::query()
            ->selectRaw('service_id, TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age, COUNT(*) as bambini')
            ->join('children', 'child_id', '=', 'children.id')
            ->groupBy(['service_id', 'age'])
            ->get()
            ->groupBy('service_id')->map->pluck('bambini', 'age');
    }

    /**
     * Custom view renderer
     *
     * @return string
     */
    public function view()
    {
        $results = $this->results();
        $column_name = 'Bambini';
        $column_count = $results->map->flip()->flatten()->max();

        return view(static::$template, compact('results', 'column_count', 'column_name'));
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Quanti bambini di che età? Divisi in fasce di un anno per servizio.';
    }
}
