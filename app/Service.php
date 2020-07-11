<?php

namespace App;

use App\Scopes\PastYearScope;
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

    public function children()
    {
        return $this->belongsToMany(Child::class);
    }
}
