<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogMessage extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'errors' => 'json',
    ];

    /**
     * Retrict query to children services only.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForChildren($query)
    {
        return $query->whereNotIn('service', config('bs.import.family_services'));
    }

    /**
     * Retrict query to family services only.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForFamilies($query)
    {
        return $query->whereIn('service', config('bs.import.family_services'));
    }
}
