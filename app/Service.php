<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
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
     * Retrict query to children services only.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForChildren($query)
    {
        return $query->whereNotIn('id', config('bs.import.family_services'));
    }

    /**
     * Retrict query to family services only.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForFamilies($query)
    {
        return $query->whereIn('id', config('bs.import.family_services'));
    }

    /**
     * Retrieve the children whose are taking part in the service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function children()
    {
        return $this->belongsToMany(Child::class);
    }

    /**
     * Retrieve the children whose are taking part in the service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function families()
    {
        return $this->belongsToMany(Family::class);
    }
}
