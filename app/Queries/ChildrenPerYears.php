<?php

namespace App\Queries;

use App\Child;
use Carbon\Carbon;

class ChildrenPerYears extends QueryObject
{
    /**
     * Execute the query:
     *  9) Quanti bambini per quanti anni sono in carico a L’abilità?
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return Child::with(['services' => function ($query) {
                // return $query->whereYear('first_appearance', '<=', config('bs.year'));
            }])
            ->whereHas('services', function ($query) {
                return $query->whereYear('first_appearance', '<=', config('bs.year'));
            })
            ->get()
            ->flatMap(function ($child) {
                return [
                    $child->id => $this->diffInYears($child->services->first()->pivot),
                ];
            })
            ->countBy()
            ->sortKeys();
    }

    protected function diffInYears($pivot)
    {
        $from = $pivot->end_of_charge ?? Carbon::createMidnightDate(config('bs.year'), 1, 1);

        return $from->addYear()->diffInYears($pivot->first_appearance);
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return '9) Quanti bambini per quanti anni sono in carico a L’abilità?';
    }
}
