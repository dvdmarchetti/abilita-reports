<?php

namespace App\Http\Controllers;

use App\Imports\BilancioSocialeImport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = Storage::files('input');

        foreach ($files as $path) {
            $service = Str::of($path)->after('SCHEDA UNICA GESTIONE UTENTI-')->before('_rev');
            Log::channel('import')->info('Processing service input file.', ['filename' => $path]);

            (new BilancioSocialeImport)->for($service)->import($path);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
}
