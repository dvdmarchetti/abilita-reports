<?php

namespace App\Queries;

use App\Child;

class ChildrenPerHomeCity extends QueryObject
{
    /**
     * Execute the query:
     *  6) Quanti residenti a Milano? Quanti fuori Milano?
     *
     * @return \Illuminate\Support\Collection
     */
    public function results()
    {
        $milanesi = Child::where('home_city', 'MILANO')->count();
        $esterni = Child::where('home_city', '<>', 'MILANO')->count();

        return collect([
            'MILANO' => $milanesi,
            'ALTRO' => $esterni,
        ]);
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    static public function question()
    {
        return 'Quanti bambini residenti a Milano? Quanti fuori Milano?';
    }
}
