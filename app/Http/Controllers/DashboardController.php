<?php

namespace App\Http\Controllers;

use App\Child;
use App\Family;
use App\LogMessage;
use App\Service;
use Spatie\QueryBuilder\QueryBuilder;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $childrenCount = Child::count();
        $familiesCount = Family::count();
        $services = Service::all();
        $logsCount = LogMessage::count();
        $logs = QueryBuilder::for(LogMessage::class)
            ->allowedFilters(['service', 'spreadsheet', 'child'])
            ->get();

        return view('dashboard', compact('childrenCount', 'familiesCount', 'services', 'logs', 'logsCount'));
    }
}
