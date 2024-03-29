<?php

namespace App;

use App\Relations\ChildService;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * Filter for active children. A child is active if he has
     * at least one active service.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereHas('services', function ($query) {
            $query->where('is_active', true);
        });
    }

    /**
     * Retrieve the related family of the child.
     *
     * @return \App\Family
     */
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * Retrieve the services associated with this child.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
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
