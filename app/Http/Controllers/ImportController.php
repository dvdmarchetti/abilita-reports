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
        Log::stack(['single', 'import'])->info("---------------------");

        $version = config('bs.version');
        Log::info("Running v" . $version);

        Log::info('Import begin');

        // DB::transaction(function () {
        Log::debug('Cleaning up old data...');
        Artisan::call('migrate:fresh --force -q');

        $this->processFolder('input/children', function ($service, $file) {
            (new ChildWorksheetImport)->for($service)->import($file);
        });

        $this->processFolder('input/families', function ($service, $file) {
            (new FamilyWorksheetImport)->for($service)->import($file);
        });

        Log::debug('Removing extra data...');
        $this->removeExtraData();
        // });

        Log::info('Import complete');
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
        Log::info('Importing folder.', ['folder' => $path]);

        $files = Storage::files($path);

        foreach ($files as $file) {
            if (! Str::of($file)->basename()->startsWith('.')) {
                $service = Str::of($file)->match('/SCHEDA UNICA (?:GESTIONE UTENTI-|GU_)(.*?)_/');
                Log::channel('import')->info('Processing service input file.', ['filename' => $file]);

                $callback($service, $file);
            }
        }
    }

    protected function removeExtraData()
    {
        $orphanChildren = Child::doesntHave('services')->get('id');
        $orphanFamilies = Family::doesntHave('services')->doesntHave('children')->get('id');
        Log::debug('Extra data before removal:', ['children_count' => $orphanChildren->count(), 'families_count' => $orphanFamilies->count()]);
        Log::debug('Orphan childrens:', $orphanChildren->toArray());
        Log::debug('Orphan families:', $orphanFamilies->toArray());

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

        $orphanChildren = Child::doesntHave('services')->count();
        $orphanFamilies = Family::doesntHave('services')->doesntHave('children')->count();
        Log::debug('Extra data after removal:', ['children' => $orphanChildren, 'families' => $orphanFamilies]);
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
