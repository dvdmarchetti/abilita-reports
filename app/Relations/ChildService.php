<?php

namespace App\Relations;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ChildService extends Pivot
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'first_appearance',
        'end_of_charge',
        'from',
        'to',
    ];
}
