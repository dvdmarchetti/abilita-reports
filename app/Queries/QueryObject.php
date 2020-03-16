<?php

namespace App\Queries;

abstract class QueryObject
{
    /**
     * Handle the incoming request to this query object.
     *
     * @return \Illuminate\Http\Response
     */
    abstract public function __invoke();
}