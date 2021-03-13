<?php

namespace App\Relations;

use App\Family;
use App\Service;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FamilyService extends Pivot
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

    /**
     * Retrieve the related family.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * Retrieve the related service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
