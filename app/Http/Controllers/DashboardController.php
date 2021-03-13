<?php

namespace App\Http\Controllers;

use App\LogMessage;
use App\Service;
use Illuminate\Support\Facades\Route;
use Spatie\QueryBuilder\QueryBuilder;

class DashboardController extends Controller
{
    public function children()
    {
        $currentRouteName = Route::currentRouteName();
        $services = Service::forChildren()->get();
        $logs = QueryBuilder::for(LogMessage::class)
            ->allowedFilters(['service', 'spreadsheet'])
            ->forChildren()
            ->get();

        return view('dashboard', compact(
            'currentRouteName',
            'services',
            'logs',
        ));
    }

    public function families()
    {
        $currentRouteName = Route::currentRouteName();
        $services = Service::forFamilies()->get();
        $logs = QueryBuilder::for(LogMessage::class)
            ->allowedFilters(['service', 'spreadsheet', 'child'])
            ->forFamilies()
            ->get();

        return view('dashboard', compact(
            'currentRouteName',
            'services',
            'logs',
        ));
    }
}
