<?php

namespace App\Queries;

use App\Child;

class ChildrenPerNationality extends QueryObject
{
    /**
     * Execute the query:
     *  5) Quanti per nazionalità? Italiana o Straniera
     *
     * @return \Illuminate\Support\Collection
     */
    public function __invoke()
    {
        $italiani = Child::where('nationality', 'ITALIA')->count();
        $stranieri = Child::where('nationality', '<>', 'ITALIA')->count();

        return collect([
            'ITALIA' => $italiani,
            'ALTRO' => $stranieri,
        ]);
    }
}
