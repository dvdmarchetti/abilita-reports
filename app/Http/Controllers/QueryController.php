<?php

namespace App\Http\Controllers;

use App\Queries\ChildrenPerService;
use App\Queries\ChildrenTotal;
use Illuminate\Support\Str;

class QueryController extends Controller
{
    /**
     * Hold all the available queries keyed by route-slug.
     *
     * @var array
     */
    protected $queries = [
        ChildrenTotal::class,
        ChildrenPerService::class,
    ];

    public function __construct()
    {
        $this->queries = collect($this->queries)->keyBy(function ($class) {
            return (string) $this->slugify($class);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->queries->keys();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $class = $this->queries->get($slug, function () {
            return abort(404);
        });

        return (new $class)(request());
    }

    /**
     * Extract the slug name from the query class name.
     *
     * @param string $class
     * @return Str
     */
    protected function slugify($class)
    {
        return Str::of($class)->after('\\Queries\\')->snake()->slug();
    }
}
