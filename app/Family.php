<?php

namespace App;

use App\Relations\FamilyService;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
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
     * Filter families on children count.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithMoreThanOneChild($query)
    {
        return $query->has('children', '>', 1);
    }

    /**
     * Retrieve the children of this family.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Child::class);
    }

    /**
     * Retrieve the services associated with this family.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->belongsToMany(Service::class)
            ->using(FamilyService::class)
            ->withPivot([
                'activity_1',
                'activity_2',
                'activity_3',
                'activity_4',
            ]);
    }
}
