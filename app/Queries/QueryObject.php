<?php

namespace App\Queries;

abstract class QueryObject
{
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
        $results = $this->results();

        return view(static::$template ?? 'queries.plain', compact('results'));
    }

    /**
     * Return the query in text form.
     *
     * @return string
     */
    abstract static public function question();
}
