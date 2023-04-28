<?php

namespace App\Queries;

use App\Child;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ChildrenPerYears extends QueryObject
{
    /**
     * Execute the query
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        return Child::with('services')
            ->get()
            ->flatMap(function ($child) {
                Log::debug('Extracting details for children', ['child-id' => $child->id, 'services' => $child->services->count()]);

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
        return 'Quanti bambini per quanti anni sono in carico a L’abilità?';
    }
}
