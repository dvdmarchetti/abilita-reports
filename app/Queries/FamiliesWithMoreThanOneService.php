<?php

namespace App\Queries;

use App\Family;

class FamiliesWithMoreThanOneService extends QueryObject
{
    /**
     * Execute the query
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        $singoli = Family::withCount('services')->has('services', 1)->count();
        $multipli = Family::withCount('services')->has('services', '>', 1)->count();

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
        return 'Quante famiglie usufruiscono di almeno un servizio in area famiglia?';
    }
}
