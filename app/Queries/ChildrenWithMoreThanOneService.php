<?php

namespace App\Queries;

use App\Child;

class ChildrenWithMoreThanOneService extends QueryObject
{
    /**
     * Execute the query:
     *  13) Quanti bambini usufruiscono di almeno servizio?
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        $singoli = Child::withCount('services')->has('services', 1)->count();
        $multipli = Child::withCount('services')->has('services', '>', 1)->count();

        return collect([
            'SINGOLO SERVIZIO' => $singoli,
            'ALMENO DUE SERVIZI' => $multipli,
        ]);
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return '13) Quanti bambini usufruiscono di almeno servizio?';
    }
}