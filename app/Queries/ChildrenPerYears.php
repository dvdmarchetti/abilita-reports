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
    public function __invoke()
    {
        return Child::with('services')
            ->whereHas('services')
            ->get()
            ->flatMap(function ($child) {
                return [
                    $child->id => $this->diffInYears($child->services->first()->pivot),
                ];
            })
            ->groupBy(fn($child) => $child)
            ->map->count();
    }

    protected function diffInYears($pivot)
    {
        $from = $pivot->end_of_charge ?? Carbon::createMidnightDate(config('bs.year'), 1, 1);

        return $from->addYear()->diffInYears($pivot->first_appearance);
    }
}
