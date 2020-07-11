<?php

namespace App\Http\Controllers;

use App\Child;
use App\Family;
use App\LogMessage;
use App\Queries\ChildrenPerAgeRange;
use App\Queries\ChildrenPerDiagnosisArea;
use App\Queries\ChildrenPerEndReason;
use App\Queries\ChildrenPerGender;
use App\Queries\ChildrenPerHomeCity;
use App\Queries\ChildrenPerMaxDiagnosis;
use App\Queries\ChildrenPerNationality;
use App\Queries\ChildrenPerService;
use App\Queries\ChildrenPerServiceByMonths;
use App\Queries\ChildrenPerSourceChannel;
use App\Queries\ChildrenPerYears;
use App\Queries\ChildrenTotal;
use App\Service;
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
        ChildrenPerGender::class,
        ChildrenPerAgeRange::class,
        ChildrenPerNationality::class,
        ChildrenPerHomeCity::class,
        ChildrenPerDiagnosisArea::class,
        ChildrenPerMaxDiagnosis::class,
        ChildrenPerYears::class,
        ChildrenPerServiceByMonths::class,
        ChildrenPerEndReason::class,
        ChildrenPerSourceChannel::class,
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
        $childrenCount = Child::count();
        $familiesCount = Family::count();
        $familiesWithMoreThanAChildCount = Family::has('children', '>', 1)->count();
        $servicesCount = Service::count();

        $queries = $this->queries->map(function ($class) {
            return (new $class);
        });

        return view('queries', compact(
            'queries',
            'childrenCount',
            'familiesCount',
            'familiesWithMoreThanAChildCount',
            'servicesCount',
        ));
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

        return (new $class)();
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
