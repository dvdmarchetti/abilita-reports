<?php

namespace App\Queries;

use App\Relations\ChildService;

class ChildrenPerMaxDiagnosis extends QueryObject
{
    /**
     * Execute the query:
     *  8) Quanti bambini con più diagnosi?
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        $childrenPerDiagnosis = ChildService::query()
            ->selectRaw('count(distinct child_id) as bambini, max(diagnosis_count) as diagnosis')
            ->groupBy('child_id')
            ->get()
            ->countBy(function ($row) {
                return $row->diagnosis;
            })
            ->sortKeys();

        foreach ($childrenPerDiagnosis as $i => $count) {
            for ($j = 1; $j < $i; $j++) {
                $childrenPerDiagnosis->put($j, $childrenPerDiagnosis->get($j) + $count);
            }
        }

        return $childrenPerDiagnosis;
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return '8) Quanti bambini con più diagnosi?';
    }
}
