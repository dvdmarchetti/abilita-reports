<?php

namespace App\Queries;

use Illuminate\Http\Request;

abstract class QueryObject
{
    /**
     * Handle the incoming request to this query object.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    abstract public function __invoke(Request $request);
}