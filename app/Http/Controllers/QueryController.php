<?php

namespace App\Http\Controllers;

use App\Child;
use App\Family;
use App\Queries\ChildrenActive;
use App\Queries\ChildrenPerAgeRange;
use App\Queries\ChildrenPerDiagnosisArea;
use App\Queries\ChildrenPerEndReason;
use App\Queries\ChildrenPerGender;
use App\Queries\ChildrenPerHomeCity;
use App\Queries\ChildrenPerMaxDiagnosis;
use App\Queries\ChildrenPerNationality;
use App\Queries\ChildrenPerNationalityItalianOrOther;
use App\Queries\ChildrenPerService;
use App\Queries\ChildrenPerServiceByMonths;
use App\Queries\ChildrenPerSourceChannel;
use App\Queries\ChildrenPerYears;
use App\Queries\ChildrenWithMoreThanOneService;
use App\Queries\FamiliesByActivity;
use App\Queries\FamiliesPerService;
use App\Queries\FamiliesPerServiceByMonths;
use App\Queries\FamiliesWithMoreThanOneActivity;
use App\Queries\FamiliesWithMoreThanOneService;
use App\Queries\ServiceCountPerChildren;
use App\Service;
use Illuminate\Support\Str;

class QueryController extends Controller
{
    /**
     * Hold all the available queries keyed by route-slug.
     *
     * @var array
     */
    protected $childrenQueryList = [
        ChildrenActive::class,
        ChildrenPerService::class,
        ChildrenPerGender::class,
        ChildrenPerAgeRange::class,
        ChildrenPerNationalityItalianOrOther::class,
        ChildrenPerNationality::class,
        ChildrenPerHomeCity::class,
        ChildrenPerDiagnosisArea::class,
        ChildrenPerMaxDiagnosis::class,
        ChildrenPerYears::class,
        ChildrenPerServiceByMonths::class,
        ChildrenPerEndReason::class,
        ChildrenPerSourceChannel::class,
        ChildrenWithMoreThanOneService::class,
        ServiceCountPerChildren::class,
    ];

    protected $familiesQueryList = [
        FamiliesPerServiceByMonths::class,
        FamiliesWithMoreThanOneService::class,
        FamiliesPerService::class,
        FamiliesByActivity::class,
        FamiliesWithMoreThanOneActivity::class,
    ];

    public function __construct()
    {
        $this->childrenQueries = $this->parseQueries($this->childrenQueryList);
        $this->familiesQueries = $this->parseQueries($this->familiesQueryList);
    }

    /**
     * Key queries by slug of class name;
     *
     * @param \Illuminate\Support\Collection|array $queries
     * @return \Illuminate\Support\Collection
     */
    protected function parseQueries($queries)
    {
        return collect($queries)->keyBy(function ($class) {
            return (string) $this->slugify($class);
        })->map(function ($class) {
            return (new $class);
        });
    }

    /**
     * Display a listing of the resource.
     *p
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $childrenCount = Child::count();
        $familiesCount = Family::count();
        $familiesWithMoreThanOneChildCount = Family::withMoreThanOneChild()->count();
        $servicesCount = Service::count();

        $childrenQueries = $this->childrenQueries;
        $familiesQueries = $this->familiesQueries;

        return view('queries', compact(
            'familiesQueries',
            'childrenQueries',
            'childrenCount',
            'familiesCount',
            'familiesWithMoreThanOneChildCount',
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
