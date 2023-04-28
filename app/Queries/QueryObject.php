<?php

namespace App\Queries;

use Illuminate\Support\Facades\Log;

abstract class QueryObject
{
    static protected $errorTemplate = 'queries.error';
    static protected $template = null;

    /**
     * Handle the incoming request to this query object.
     *
     * @return \Illuminate\Http\Response
     */
    abstract public function results();

    /**
     * Custom view renderer
     *
     * @return string
     */
    public function view()
    {
        Log::debug('Extracting results for query object: ' . static::class);

        try {
            $results = $this->results();
        } catch (\Exception $e) {
            Log::error('Exception while extracting result set.');
            report($e);
            return view(static::$errorTemplate);
        }


        return view(static::$template ?? 'queries.plain', compact('results'));
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    abstract static public function question();
}
