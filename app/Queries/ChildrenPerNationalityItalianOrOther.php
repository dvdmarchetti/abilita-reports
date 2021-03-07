<?php

namespace App\Queries;

use App\Child;

class ChildrenPerNationalityItalianOrOther extends QueryObject
{
    /**
     * Execute the query:
     *  5) Quanti per nazionalità? Italiana o Straniera
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        $italiani = Child::where('nationality', 'ITALIA')->count();
        $stranieri = Child::where('nationality', '<>', 'ITALIA')->count();

        return collect([
            'ITALIA' => $italiani,
            'ALTRO' => $stranieri,
        ]);
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Quanti bambini per nazionalità? Italiana o Straniera';
    }
}
