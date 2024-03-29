<?php

namespace App\Http\Controllers;

use App\Child;
use App\Family;
use App\Imports\ChildWorksheetImport;
use App\Imports\FamilyWorksheetImport;
use App\Relations\ChildService;
use App\Relations\FamilyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
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
    public function run()
    {
        // DB::transaction(function () {
            Artisan::call('migrate:fresh --force -q');

            $this->processFolder('input/children', function ($service, $file) {
                (new ChildWorksheetImport)->for($service)->import($file);
            });

            $this->processFolder('input/families', function ($service, $file) {
                (new FamilyWorksheetImport)->for($service)->import($file);
            });

            $this->removeExtraData();
        // });

        return redirect()->back();
    }

    /**
     * Find excel files which needs to be imported and
     * pass them to the provided callback function.
     *
     * @param string $path
     * @param Callable $callback
     * @return void
     */
    protected function processFolder($path, $callback)
    {
        $files = Storage::files($path);

        foreach ($files as $file) {
            if (! Str::of($file)->basename()->startsWith('.')) {
                $service = Str::of($file)->match('/SCHEDA UNICA (?:GESTIONE UTENTI-|GU_)(.+)_rev/');
                Log::channel('import')->info('Processing service input file.', ['filename' => $file]);

                $callback($service, $file);
            }
        }
    }

    protected function removeExtraData()
    {
        $relations = collect([ChildService::query(), FamilyService::query()]);

        $relations->each(function ($relation) {
            $relation->where(function($query) {
                $query->whereYear('first_appearance', '!=', 9999)
                    ->whereYear('first_appearance', '>', config('bs.year'));
            })
            ->orWhere(function ($query) {
                $query->whereNotNull('end_of_charge')
                    ->whereYear('end_of_charge', '<', config('bs.year'));
            })
            ->delete();
        });

        Child::doesntHave('services')->delete();
        Family::doesntHave('services')->doesntHave('children')->delete();
    }

    /**
     * Cleanup the imported data.
     *
     * @param Request $request
     * @return void
     */
    public function cleanup(Request $request)
    {
        Artisan::call('migrate:fresh --force -q');

        return redirect()->back();
    }
}
