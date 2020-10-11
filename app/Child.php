<?php

namespace App;

use App\Relations\ChildService;
use App\Scopes\SQLiteCollateNocaseScope;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'birth_date',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)
            ->using(ChildService::class)
            ->withPivot([
                'diagnosis_area',
                'diagnosis_count',
                'first_appearance',
                'end_of_charge',
                'end_reason',
                'from',
                'to',
                'attendance_months',
                'source'
            ]);
    }
}
