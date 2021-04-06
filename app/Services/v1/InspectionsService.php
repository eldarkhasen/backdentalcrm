<?php


namespace App\Services\v1;


use Illuminate\Http\Request;

interface InspectionsService
{
    public function store(Request $request);
}
